<?php

namespace App\Http\Controllers;

use App\Models\BlockLabel;
use App\Models\Image;
use App\Models\ImageLabel;
use App\Models\LabelAnswer;
use App\Models\Project;
use App\Traits\SendRequestTrait;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ImageController extends Controller
{
    use StorageTrait;
    use sendRequestTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $project_id): \Illuminate\Http\JsonResponse
    {
        $project = Project::find($project_id);
        if ($project){
            $project->increment('num_image');
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $file_path = $file->storeAs('public/'.$project_id, $originalName);
            $image = Image::create([
                'user_id' => Auth::user()->id,
                'project_id' => $project_id,
                'file_name' => $originalName,
                'file_path' => '/storage/'.$project_id.'/'.$originalName,
                'size' => $size,
            ]);
            if($this->checkingQualityImage($image)){
                $this->detectGastritisImage($image);
                return response()->json([
                    "image" => $image,
                    "message" => "Upload image successfully",
                    "project" => $project
                ],200);
            }else{
                $image->delete();
                return response()->json([
                    'message' => 'Quality of image  is not good enough, please upload another image'
                ], 400);
            }

        }
        return response()->json([
            'message' => 'Not exist project with id '.$project_id
        ], 400);
    }

    public function destroy($id): RedirectResponse
    {
        $image = Image::find($id);
        if($image){
            $image->delete();
        }
        return back();
    }

    public function processing($image_id, $run_again):RedirectResponse
    {
        $image = Image::find($image_id);
        if ($image){
            $image_label = $image->imageLabels()->where('user_id', '=', -1)
                ->whereHas('label', function ($query) {
                    $query->ImageQuality();
                })->first();
            if ($run_again || $image_label == null){
                if($this->checkingQualityImage($image)){
                    $this->detectGastritisImage($image);
                }else{
                    $image->delete();
                }
            }
        }
        return back();
    }

    public function confirmLabel(Request $request)
    {
        $input = $request->all();
        $blocks = $input['blocks'];
        $new_zone_label_id = $input['zone_id'];
        $image_id = $input['image_id'];

        // confirm block Label
        foreach ($blocks as $block){
            $blockLabel = BlockLabel::where('block_id',$block['id'])->where('user_id', '=', Auth::user()->id)->first();
            if ($blockLabel) {
                $blockLabel->update([
                    'label_id' => $block['label_id'],
                    'accuracy' => 100,
                ]);
            }else {
                BlockLabel::create([
                    'block_id' => $block['id'],
                    'label_id' => $block['label_id'],
                    'user_id' => Auth::user()->id,
                    'accuracy' => 100,
                ]);
            }
        }

        // confirm zone label
        $image = Image::find($image_id);
        if ($image && $new_zone_label_id){
            $zoneLabel = $image->zoneLabel();
            if ($zoneLabel) {
                    $zoneLabel->update([
                        'label_id' => $new_zone_label_id
                    ]);
            }else{
                $zoneLabel = ImageLabel::create([
                    "image_id" => $image_id,
                    "label_id" => $new_zone_label_id,
                    "user_id" => Auth::user()->id,
                    "accuracy" => 100
                ]);
            }
        }
        return back();
    }

}
