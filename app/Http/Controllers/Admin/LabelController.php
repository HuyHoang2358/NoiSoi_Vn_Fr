<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LabelController extends Controller
{
    public function index($label_type): \Inertia\Response
    {
        return Inertia::render('Admin/Label',[
            'labels'=> DB::table('labels')->where('type',$label_type)->get(),
            'state' => (object) [
                'selectedKeys' => ['label-manager-'.$label_type],
                'openKeys'=> ['label-manager'],
            ],
            'title' => 'Label '.Str::title($label_type).' Manager',
        ]);
    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Label::create($request->validate([
            'name' => 'required',
            'class_id' => 'required',
            'type' => 'required',
        ]));
        return to_route('admin.label.index',[$request->type]);
    }
    public function update(Request $request, $id){
        $label = Label::find($id);
        $label->update($request->validate([
            'name' => 'required',
            'class_id' => 'required',
            'type' => 'required',
        ]));
        return to_route('admin.label.index',[$request->type]);
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $label = Label::find($id);
        $label_type = $label->type;
        $label->delete();
        return to_route('admin.label.index',[$label_type]);
    }
}
