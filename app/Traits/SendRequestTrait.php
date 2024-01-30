<?php
namespace App\Traits;


use App\Models\Image;
use App\Models\Label;
use App\Models\LabelAnswer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


trait SendRequestTrait
{
    private string $endpoint = '192.168.91.152:8000';
    private string $checkQualityApiPath = '/check_quality';
    private string $detectApiPath = '/detect';

    public function sendCheckQualityRequest($image_base64)
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
        } catch (GuzzleException $e) {
            return [
                "softmax" => "-1",
                "class_id" => "-1"
            ];
        }
    }

    protected function autoCheckingQualityImage($image): void
    {
        // get base64 of image
        $image_base64 = $this->getBase64('public/' . $image->project_id . '/' . $image->file_name);

        // send request to AI
        $response = $this->sendCheckQualityRequest($image_base64);

        // update label answer
        $label = Label::where('class_id', strval($response['class_id']))
            ->where('type', '=', 'quality')->first();

        $label_answer = LabelAnswer::where('image_id', '=', $image->id)
            ->where('user_id', '=', -1)
            ->whereHas('label', function ($query) {
                $query->quality();
            })->first();

        // check exist quality label answer of AI
        if ($label_answer) {
            // update new result
            $label_answer->update([
                'label_id' => ($label) ? $label->id : $response['class_id'],
                'accuracy' => $response['softmax'] * 100 . "",
            ]);
        } else {
            // create new record
            LabelAnswer::create([
                'image_id' => $image->id,
                'user_id' => -1,
                'label_id' => ($label) ? $label->id : $response['class_id'],
                'accuracy' => $response['softmax'] * 100 . "",
            ]);
        }
    }

    public function sendDetectGastritisRequest($image_base64)
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

    protected function autoDetectGastritisImage($image): void
    {
        // get base64 of image
        $image_base64 = $this->getBase64('public/' . $image->project_id . '/' . $image->file_name);
        // send request to AI
        $response = $this->sendDetectGastritisRequest($image_base64);

        foreach ($response as $item) {

            $label = Label::where('class_id', strval($item['class_id']))
                ->where('type', '=', 'gastritis')->first();

            $sub_image = Image::where('parent_id', $image->id)
                ->where('file_name', '=', pathinfo($image->file_name, PATHINFO_FILENAME) . "_" . $item["no_img"])->first();

            if ($sub_image) {
                $sub_image->update([
                    'top' => $item['top'],
                    'left' => $item['left'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                ]);
            } else {
                $sub_image = Image::create([
                    'user_id' => $image->user_id,
                    'project_id' => $image->project_id,
                    'parent_id' => $image->id,
                    'file_name' => pathinfo($image->file_name, PATHINFO_FILENAME) . "_" . $item["no_img"],
                    'file_path' => "",
                    'size' => 0,
                    'top' => $item['top'],
                    'left' => $item['left'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                ]);
            }

            $label_answer = LabelAnswer::where('image_id', '=', $sub_image->id)
                ->where('user_id', '=', -1)
                ->whereHas('label', function ($query) {
                    $query->gastritis();
                })->first();

            if ($label_answer) {
                $label_answer->update([
                    'label_id' => ($label) ? $label->id : $item['class_id'],
                    'accuracy' => ($item['softmax']) ? $item['softmax'] * 100 . "" : 0,
                ]);
            } else {
                LabelAnswer::create([
                    'image_id' => $sub_image->id,
                    'user_id' => -1,
                    'label_id' => ($label) ? $label->id : $item['class_id'],
                    'accuracy' => ($item['softmax']) ? $item['softmax'] * 100 . "" : 0,
                ]);
            }
        }
    }
}
