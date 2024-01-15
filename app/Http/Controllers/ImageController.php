<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Project;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use StorageTrait;

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
}
