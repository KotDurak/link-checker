<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function view(Project $project)
    {
        return view('project.view', ['project' => $project]);
    }
}
