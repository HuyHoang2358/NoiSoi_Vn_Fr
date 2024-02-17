<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectManagerController extends Controller
{
   public function index(): \Inertia\Response
   {
       return Inertia::render('Admin/ProjectManager',[
           'projects'=> Project::all(),
           'state' => (object) [
               'selectedKeys' => ['project-manager-index'],
               'openKeys'=> ['project-manager'],
           ],
           'title' => 'Project Manager',
       ]);
   }
   public function setting() {
       return Inertia::render("Admin/ProjectSetting",[
           'qualityImagesLabels' => Label::imageQuality()->get(),
           'blockImagesLabels' => Label::blockQuality()->get(),
           'state' => (object) [
               'selectedKeys' => ['project-manager-setting'],
               'openKeys'=> ['project-manager'],
           ],
           'title' => 'Project Setting',
       ]);
   }
}
