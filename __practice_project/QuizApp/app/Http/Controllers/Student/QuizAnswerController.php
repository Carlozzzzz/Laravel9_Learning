<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StudentQuizAnswer;
use Illuminate\Http\Request;

class QuizAnswerController extends Controller
{
    public function store(Request $request) {
        $xdata = array();
        $userId = auth()->user()->id;
        
        $validated = $request->validate([
            'question_id' => 'integer',
            'choice_id' => 'integer',
        ]);

        $validated['user_id'] = $userId;

        if(isset($validated['choice_id'])) {
            $validated['is_answered'] = 1;
        } else {
            $validated['is_answered'] = null;
        }

        $xarr_param = array();
        $xarr_param = [
            'question_id' => $validated['question_id'],
            'user_id' => $userId
        ];

        StudentQuizAnswer::updateOrCreate($xarr_param, $validated);
        
        $xdata['message'] = "Answer has been successfully submitted.";

        return response()->json($xdata);
    }
}
