<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\LabelAnswer;
use App\Models\Project;
use App\Traits\SendRequestTrait;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $input =  $request->all();
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $size = $file->getSize();
        $file_path = $file->storeAs('public/'.$project_id, $originalName);

        $image = Image::create([
            'user_id' => Auth::user()->id,
            'project_id' => $project_id,
            'parent_id' => null,
            'file_name' => $originalName,
            'file_path' => '/storage/'.$project_id.'/'.$originalName,
            'size' => $size,
            'width' => 0,
            'height' => 0,
            'top' => 0,
            'left' => 0,
        ]);
        return response()->json($image);
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $image = Image::find($id);
        if($image){
            $project_id = $image->project->id;
            Storage::delete("public/".$project_id."/".$image->file_name);
            $image->delete();
        }
        return back();
    }
    public function autoCheckingQuality($image_id): \Illuminate\Http\JsonResponse
    {
        $image = Image::find($image_id);
        if ($image){
            $this->autoCheckingQualityImage($image);
            return response()->json([
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'fail'
        ]);
    }
    public function autoDetectGastritis($image_id): \Illuminate\Http\JsonResponse
    {
        $image = Image::find($image_id);
        if ($image){
            $this->autoDetectGastritisImage($image);
            return response()->json([
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'fail'
        ]);
    }
    public function confirmLabel(Request $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $sub_images = $input['sub_images'];
        foreach ($sub_images as $sub_image){
            $answerLabel = LabelAnswer::where('image_id','=',$sub_image['id'])->where('user_id','<>',-1)->first();
            if ($answerLabel){
                $answerLabel->update([
                    'label_id' => $sub_image['label_id'],
                    'user_id' => Auth::user()->id,
                ]);
            }else{
                LabelAnswer::create([
                    'image_id' => $sub_image['id'],
                    'label_id' => $sub_image['label_id'],
                    'user_id' => Auth::user()->id,
                    'accuracy' => 100,
                ]);
            }
        }
        return response()->json([
            'message' => 'success',
            "current_image" => Image::find(Image::find($sub_images[0]['id'])->parent_id),
        ]);
    }
}
