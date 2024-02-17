<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LabelController extends Controller
{
    public function index($category_slug): \Inertia\Response|\Illuminate\Http\RedirectResponse
    {
        $category = Category::where('slug',$category_slug)->first();
        if ($category){
            return Inertia::render('Admin/LabelManager',[
                'categories' => Category::all(),
                'currentCategory' => $category,
                'labels'=> Label::where('category_id',$category->id)->OrderBy('class_id','ASC')->get(),
                'state' => (object) [
                    'selectedKeys' => ['label-manager-'.$category_slug],
                    'openKeys'=> ['label-manager'],
                ],
                'title' => Str::title($category->name).' Label Manager',
            ]);
        }
        return back();

    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $input = $request->validate([
            'name' => 'required',
            'class_id' => '',
            'category_id' => 'required',
            'status' => '',
        ]);
        Label::create([
            'name' => $input['name'],
            'class_id' => $input['class_id'],
            'category_id' => $input['category_id'],
            'status' => true,
        ]);
        return back();
    }
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $label = Label::find($id);
        if($label){
            $label->update($request->validate([
                'name' => 'required',
                'class_id' => '',
                'category_id' => 'required',
            ]));
        }

        return back();
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $label = Label::find($id);
        if ($label){
            $label->delete();
        }

        return back();
    }
    public function changeStatus($id): \Illuminate\Http\RedirectResponse
    {
        $label = Label::find($id);
        if ($label){
            $label->update([
                'status' => !$label->status
            ]);
        }

        return back();
    }
}
