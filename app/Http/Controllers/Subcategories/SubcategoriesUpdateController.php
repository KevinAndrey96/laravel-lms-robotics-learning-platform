<?php

namespace App\Http\Controllers\Subcategories;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Services\MediaUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubcategoriesUpdateController extends Controller
{
    private MediaUploadService $mediaService;

    public function __construct(?MediaUploadService $mediaService = null)
    {
        $this->mediaService = $mediaService ?? new MediaUploadService();
    }

    public function update(Request $request): RedirectResponse
    {
        $fields = [
            'name' => 'required|string',
            'description' => 'required|string',
            'icon_url' => 'nullable|mimes:jpg,jpeg,png',
        ];
        $message = [
            'required' => ':attribute es requerido',
        ];
        $this->validate($request, $fields, $message);

        $subcategory = Subcategory::findOrFail($request->input('subcategory_id'));
        $subcategory->name = $request->input('name');
        $subcategory->description = $request->input('description');

        if ($request->hasFile('icon_url')) {
            $subcategory->icon_url = $this->mediaService->upload($request->file('icon_url'), 'subcategory_images', $subcategory->id.'.png');
        }

        $subcategory->save();

        return redirect('/subcategories/'.$subcategory->category_id)->with('updasubcasuccess', 'Subcategoría modificada');
    }
}
