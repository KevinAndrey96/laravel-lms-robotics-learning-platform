<?php

namespace App\Http\Controllers\UploadedHomeworks;

use App\Http\Controllers\Controller;
use App\Models\Uploaded_homework;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetailMyHomeworksUploadedHomeworksController extends Controller
{
    public function detailMyHomework(Request $request, $id)
    {
        date_default_timezone_set('America/Bogota');
        $uploadedHomework = Uploaded_homework::where('user_id', $request->user()->id)->findOrFail($id);
        $homework = $uploadedHomework->homework;
        $dateTime = Carbon::parse($uploadedHomework->homework->due_date.' '.$uploadedHomework->homework->due_time);
        $currentDateTime = Carbon::now();
        $value = $currentDateTime->gt($dateTime);

        return view('uploadedHomeworks.detailMyHomework', compact('uploadedHomework', 'homework', 'value'));
    }
}
