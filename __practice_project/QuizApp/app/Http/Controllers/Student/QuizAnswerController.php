<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StudentQuizAnswer;
use App\Models\StudentQuizDetails;
use Illuminate\Http\Request;

class QuizAnswerController extends Controller
{
    public function store(StudentQuizDetails $studentQuizDetails, Request $request) {

        $xdata = array();
        $userId = auth()->user()->id;

        $validated = $request->validate([
            'question_id' => 'integer',
            'choice_id' => 'integer',
            'isFinished' => 'required|in:true,false',
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

        // dd($validated, $request->all());

        // StudentQuizAnswer::updateOrCreate($xarr_param, $validated);
        $studentQuizDetails->student_quiz_answer()->updateOrCreate($xarr_param, $validated);

        if($validated["isFinished"] == "true") {
            $studentQuizDetails->update(['review_status' => "finished"]);
        }

        $xdata['message'] = "Answer has been successfully submitted.";

        return response()->json($xdata);
    }

    
}
