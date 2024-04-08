<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentQuestionSortOrder;
use App\Models\StudentQuizAnswer;
use App\Models\StudentQuizDetails;
use Illuminate\Http\Request;

class StudentQuizResultController extends Controller
{
    public function result(StudentQuizDetails $studentQuizDetails) {
        $page = "student.quiz.result";

        $data = array();
        $userId = auth()->user()->id;
        $data['data_dataactivepage'] = "student_quiz_result";
        $data['data_quizdetails'] = $studentQuizDetails;
       
        // $data['data_studentanswers'] = $studentQuizDetails->load(['student_quiz_answer' => function($query) {
        //     $query->with(['question', 'choice'])
        //         ->where("user_id", auth()->user()->id);
        // }]);

        $data['data_studentanswers'] = StudentQuestionSortOrder::with(['question' => function($query) use($studentQuizDetails){
                $query->with(['student_quiz_answers' => function($query2) use($studentQuizDetails) {
                    $query2->with(['choice'])
                        ->where('student_quiz_details_id', $studentQuizDetails->id);
                }]);
            }])
            ->where("quiz_id", $studentQuizDetails->quiz_id)
            ->where("user_id", $userId)
            ->orderBy("question_order")
            ->get();
        
        // dd($data['data_studentanswers']);

        return view($page, $data);
    }
}
