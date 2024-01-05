<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentQuizDetails;
use Illuminate\Http\Request;

class StudentQuizDetailController extends Controller
{
    public function updateTimer(StudentQuizDetails $studentQuizDetails, Request $request) {
        $xdata = array();

        $validated = $request->validate([
            'hours' => 'required',
            'minutes' => 'required',
            'seconds' => 'required',
        ]);

        $xdata["data"] = $studentQuizDetails->update($validated);

        return response()->json($xdata);
    }
}
