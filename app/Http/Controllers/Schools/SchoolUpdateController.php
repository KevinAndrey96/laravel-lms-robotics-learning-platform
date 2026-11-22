<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Services\MediaUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SchoolUpdateController extends Controller
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
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'icon_url' => 'nullable|mimes:jpg,jpeg,png',
        ];
        $message = [
            'required' => ':attribute es requerido',
        ];
        $this->validate($request, $fields, $message);

        $school = School::findOrFail($request->input('school_id'));
        $school->name = $request->input('name');
        $school->address = $request->input('address');
        $school->city = $request->input('city');
        $school->country = $request->input('country');

        if ($request->hasFile('icon_url')) {
            $school->icon_url = $this->mediaService->upload($request->file('icon_url'), 'school_logos', $school->id . '.png');
        }

        $school->save();

        return redirect('/schools')->with('updaschoolsuccess', 'Colegio modificado');
    }
}
