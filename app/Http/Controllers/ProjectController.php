<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\LabelAnswer;
use App\Models\Project;
use App\Traits\SendRequestTrait;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{
    use StorageTrait;
    use SendRequestTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Project',[
            'myProjects' => Project::where('user_id', Auth::user()->id)->get()
        ]);
    }


    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => Auth::user()->id
        ]);
        $this->createFolder("public/".$project->id);
        return back();
    }
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $project = Project::find($id);
        $project->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return back();
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $project = Project::find($id);
        $this->deleteFolder("public/".$project->id);
        $project->delete();
        return back();
    }

    public function detail($project_id): \Inertia\Response
    {
        $project = Project::find($project_id);
        return Inertia::render('ProjectDetail',[
            'project' => $project,
            'images' => $project->images,
        ]);
    }


    public function makeLabel($project_id): \Inertia\Response
    {
        $project = Project::find($project_id);
        return Inertia::render('ProjectMakeLabel',[
            'project' => $project,
            'images' => $project->images,
            'qualityLabels' => Label::where('type','quality')->get(),
            'gastritisLabels' => Label::where('type','gastritis')->get(),
        ]);

    }

}
