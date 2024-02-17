<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/CategoryManager',[
            'categories'=> Category::all(),
            'state' => (object) [
                'selectedKeys' => ['category-manager'],
                'openKeys'=> [],
            ],
            'title' => 'Category Manager',
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $input = $request->all();
        Category::create([
            'name' => $input['name'],
            'slug' => $input['slug'] ?? Str::slug($input['name']),
        ]);
        return redirect()->back();
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $input = $request->all();
        $item = Category::find($id);
        if($item){
            $item->update([
                'name' => $input['name'],
                'slug' => $input['slug'] ?? Str::slug($input['name']),
            ]);
        }
        return back();
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $item = Category::find($id);
        $item->delete();
        return back();
    }

}
