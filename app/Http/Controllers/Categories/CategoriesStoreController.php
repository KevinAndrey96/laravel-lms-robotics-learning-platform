<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\MediaUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriesStoreController extends Controller
{
    private MediaUploadService $mediaService;

    public function __construct(?MediaUploadService $mediaService = null)
    {
        $this->mediaService = $mediaService ?? new MediaUploadService();
    }

    public function store(Request $request): RedirectResponse
    {
        $fields = [
            'name' => 'required|string',
            'description' => 'required|string',
            'icon_url' => 'required|mimes:jpg,jpeg,png',
        ];
        $message = [
            'required' => ':attribute es requerido',
        ];
        $this->validate($request, $fields, $message);

        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->icon_url = '';
        $category->save();

        if ($request->hasFile('icon_url')) {
            $category->icon_url = $this->mediaService->upload($request->file('icon_url'), 'category_images', $category->id.'.png');
            $category->save();
        }

        return redirect('/categories')->with('createschoolsuccess', 'Categoria creada');
    }
}
