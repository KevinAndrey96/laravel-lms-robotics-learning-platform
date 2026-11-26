<?php

namespace App\Http\Controllers\Scores;

use App\Http\Controllers\Controller;
use App\Models\AcademicHistory;
use App\Models\User;
use Illuminate\Http\Request;

class AcademicHistoriesScoresController extends Controller
{
    public function academicHistories(Request $request, $id)
    {
        $viewer = $request->user();
        abort_if($viewer->hasRole('Student') && (int) $id !== $viewer->id, 403);

        $user = User::findOrFail($id);
        $academicHistories = AcademicHistory::where('user_id', $user->id)->get();

        return view('scores.academicHistories', compact('academicHistories', 'user'));
    }
}
