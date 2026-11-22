<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\MediaUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreProjectsController extends Controller
{
    private MediaUploadService $mediaService;

    public function __construct(?MediaUploadService $mediaService = null)
    {
        $this->mediaService = $mediaService ?? new MediaUploadService();
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->hasFile('themeFile')) {
            $ext = strtolower($request->file('themeFile')->getClientOriginalExtension());
            if ($ext !== 'pdf') {
                return redirect('/project/creation-type/' . $request->input('subcategory_id'))
                    ->with('invalidFormat', 'Formato de archivo erróneo');
            }
        }

        if ($request->hasFile('image')) {
            $imgExt = strtolower($request->file('image')->getClientOriginalExtension());
            if (!in_array($imgExt, ['jpg', 'jpeg', 'png', 'webp'])) {
                return redirect('/project/creation-type/' . $request->input('subcategory_id'))
                    ->with('invalidFormat', 'Formato de imagen erróneo');
            }
        }

        $project = new Project();
        $project->name = $request->input('name');
        $project->description = $request->input('description') ?? '';
        $project->theme_type = 'project';

        if (Auth::user() && Auth::user()->role === 'Administrator') {
            $project->theme_type = $request->input('theme_type', 'project');
        }

        $project->icon_url = '';
        $project->is_enable = 0;
        $project->user_id = Auth::id() ?? 1;
        $project->subcategory_id = $request->input('subcategory_id');
        $project->save();

        if ($request->hasFile('themeFile')) {
            $path = $this->mediaService->upload($request->file('themeFile'), 'theme_files', $project->id . '.pdf');
            $project->is_file = 1;
            $project->description = '/' . ltrim($path, '/');
            $project->save();
        }

        if ($request->hasFile('image')) {
            $path = $this->mediaService->upload($request->file('image'), 'project_images', $project->id . '.png');
            $project->icon_url = '/' . ltrim($path, '/');
            $project->save();
        }

        return redirect('/projects')->with('StoreProjectSuccess', 'Tema agregado');
    }
}
