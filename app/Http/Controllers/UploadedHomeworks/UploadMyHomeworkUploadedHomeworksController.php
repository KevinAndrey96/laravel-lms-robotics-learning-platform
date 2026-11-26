<?php

namespace App\Http\Controllers\UploadedHomeworks;

use App\Http\Controllers\Controller;
use App\Models\Uploaded_homework;
use App\Services\MediaUploadService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UploadMyHomeworkUploadedHomeworksController extends Controller
{
    private MediaUploadService $mediaService;

    public function __construct(?MediaUploadService $mediaService = null)
    {
        $this->mediaService = $mediaService ?? new MediaUploadService();
    }

    public function uploadMyHomework(Request $request): RedirectResponse
    {
        $request->validate([
            'uploadedHomework_id' => 'required',
            'homeworkFile' => 'required|file|max:20480',
        ]);

        $file = $request->file('homeworkFile');
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['pdf', 'docx', 'zip', 'rar', 'png', 'jpg'];

        if (! in_array($extension, $allowedExtensions)) {
            return back()->with('extensionError', 'Archivo con extensión no permitida (permitidos: PDF, DOCX, ZIP, PNG, JPG)');
        }

        $uploadedHomework = Uploaded_homework::where('user_id', $request->user()->id)
            ->findOrFail($request->input('uploadedHomework_id'));

        $path = $this->mediaService->upload($file, 'homework_files');

        $uploadedHomework->path = $path;
        $uploadedHomework->status = 'send';
        $uploadedHomework->delivery_at = Carbon::now();
        $uploadedHomework->save();

        return redirect('/myHomeworks')->with('upMyHomeworkSuccess', 'Tarea subida exitosamente');
    }
}
