<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;

class EditProjectsController extends Controller
{
    public function edit($id)
    {
        $project = Project::find($id);

        return view('projects.edit', compact('project'));
    }
}
