<?php
namespace App\Traits;


use App\Models\Block;
use App\Models\BlockLabel;
use App\Models\ImageLabel;
use App\Models\Label;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\Image\Exceptions\InvalidManipulation;


trait SendRequestTrait
{
    private string $endpoint = 'http://103.106.104.244:8000';
    private string $checkQualityApiPath = '/check_quality';
    private string $detectApiPath = '/detect';

    private function sendCheckQualityRequest($image_base64)
    {
        $url = $this->endpoint . $this->checkQualityApiPath;
        $payload = [
            'bs64' => $image_base64
        ];

        // Set headers
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $client = new Client();

        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $payload,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (e) {
            return [
                "softmax" => "-1",
                "class_id" => "-1"
            ];
        }
    }
    private function sendDetectGastritisRequest($image_base64)
    {
        $url = $this->endpoint . $this->detectApiPath;
        $payload = [
            'bs64' => $image_base64
        ];

        // Set headers
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $client = new Client();

        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $payload,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

    protected function checkingQualityImage($image): bool
    {

        // get base64 of image
        $image_base64 = $this->getBase64('public/' . $image->project_id . '/' . $image->file_name);
        // send request to AI
        $response = $this->sendCheckQualityRequest($image_base64);
        // filter quality label only keep the highest softmax
        $keepingAIClass = Label::imageQuality()->where('status', '=', 1)->pluck('class_id')->toArray();
        $AI_class_id = $response['class_id'];

        if (in_array($AI_class_id, $keepingAIClass)) {
            // Update image label
            $image_label = $image->imageLabels()->where('user_id', '=', -1)
                ->whereHas('label', function ($query) {
                    $query->ImageQuality();
                })->first();

            $label = Label::where('class_id', "=", $AI_class_id)->where('category_id', '=', 1)->first();


            if ($image_label) {
                $image_label->update([
                    'label_id' => ($label) ? $label->id : null,
                    'accuracy' => $response['softmax'] * 100,
                ]);
            } else {
                // create new record
                ImageLabel::create([
                    'image_id' => $image->id,
                    'user_id' => -1,
                    'label_id' => ($label) ? $label->id : null,
                    'accuracy' => $response['softmax'] * 100,
                ]);
            }
            return true;
        }
        return false;

    }

    /**
     * @throws InvalidManipulation
     */
    protected function detectGastritisImage($image): void
    {
        // get base64 of image
        $image_base64 = $this->getBase64('public/' . $image->project_id . '/' . $image->file_name);
        // send request to AI
        $response = $this->sendDetectGastritisRequest($image_base64);

        $min_top = 1000;
        $min_left = 1000;
        $max_bottom = 0;
        $max_right = 0;

        foreach ($response as $item) {
            $min_top = min($min_top, $item['top']);
            $min_left = min($min_left, $item['left']);
            $max_bottom = max($max_bottom, $item['top'] + $item['height']);
            $max_right = max($max_right, $item['left'] + $item['width']);


            $qualityLabel = Label::blockQuality()->where('class_id', '=', $item["quality"])->first();
            $gastritisLabel = Label::gastritis()->where('class_id', '=', $item["class_id"])->first();

            $block = Block::where('image_id', '=', $image->id)
                ->where('no_img', '=', $item["no_img"])->first();

            if ($block){
                $block->update([
                    'top' => $item['top'],
                    'left' => $item['left'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                ]);
            }else{
                $block = Block::create([
                     'image_id' => $image->id,
                    'no_img' => $item["no_img"],
                    'top' => $item['top'],
                    'left' => $item['left'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                    'size'  => 0
                ]);
            }

            $blockQualityLabel = BlockLabel::where('block_id', $block->id)
                ->where('user_id', '=', -1)
                ->whereHas('label', function ($query) {
                    $query->BlockQuality();
                })->first();

            if($blockQualityLabel){
                $blockQualityLabel->update([
                    'label_id' => ($qualityLabel) ? $qualityLabel->id : $item['quality'],
                    'accuracy' => ($item['prob']) ? $item['prob'] * 100 : 0,
                ]);
            }else {
                BlockLabel::create([
                    'block_id' => $block->id,
                    'user_id' => -1,
                    'label_id' => ($qualityLabel) ? $qualityLabel->id : $item['quality'],
                    'accuracy' => ($item['prob']) ? $item['prob'] * 100 : 0,
                ]);
            }

            $blockGastritisLabel = BlockLabel::where('block_id', $block->id)
                ->where('user_id', '=', -1)
                ->whereHas('label', function ($query) {
                    $query->gastritis();
                })->first();
            if($blockGastritisLabel) {
                $blockGastritisLabel->update([
                    'label_id' => ($gastritisLabel) ? $gastritisLabel->id : $item['class_id'],
                    'accuracy' => ($item['softmax']) ? $item['softmax'] * 100 : 0,
                ]);
            }else{
                BlockLabel::create([
                    'block_id' => $block->id,
                    'user_id' => -1,
                    'label_id' => ($gastritisLabel) ? $gastritisLabel->id : $item['class_id'],
                    'accuracy' => ($item['softmax']) ? $item['softmax'] * 100 : 0,
                ]);
            }
        }

        // crop image
        //$this->cropImage('public/' . $image->project_id . '/' . $image->file_name, $min_left, $min_top, $max_right - $min_left, $max_bottom - $min_top);

    }
}
