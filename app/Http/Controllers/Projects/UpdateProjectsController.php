<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\MediaUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateProjectsController extends Controller
{
    private MediaUploadService $mediaService;

    public function __construct(?MediaUploadService $mediaService = null)
    {
        $this->mediaService = $mediaService ?? new MediaUploadService();
    }

    public function update(Request $request): RedirectResponse
    {
        $project = Project::findOrFail($request->input('project_id'));
        $project->name = $request->input('name');
        $project->description = $request->input('description') ?? '';
        $project->theme_type = 'project';

        if (Auth::user() && Auth::user()->role === 'Administrator') {
            $project->theme_type = $request->input('theme_type', 'project');
        }

        if ($request->hasFile('image')) {
            $path = $this->mediaService->upload($request->file('image'), 'project_images', $project->id.'.png');
            $project->icon_url = '/'.ltrim($path, '/');
        }

        $project->save();

        return redirect('/projects')->with('UpdaProjectSuccess', 'Tema modificado');
    }
}
