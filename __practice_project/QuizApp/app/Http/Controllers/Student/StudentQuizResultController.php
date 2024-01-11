<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentQuizAnswer;
use App\Models\StudentQuizDetails;
use Illuminate\Http\Request;

class StudentQuizResultController extends Controller
{
    public function result(StudentQuizDetails $studentQuizDetails) {
        $page = "student.quiz.result";

        $data = array();
        $data['data_dataactivepage'] = "student_quiz_result";
        $data['data_quizdetails'] = $studentQuizDetails;
        // $data['data_studentanswers'] = StudentQuizAnswer::where('student_quiz_details_id', $studentQuizDetails->id)
        //     ->with(['question', 'choice', 'student_quiz_details'])
        //     ->join('student_question_sort_orders', 'student_question_sort_orders.question_id', '=', 'student_quiz_answers.question_id')
        //     ->orderBy('student_question_sort_orders.question_order')
        //     ->get();
        $data['data_studentanswers'] = $studentQuizDetails->load(['student_quiz_answer' => function($query) {
            $query->with(['question', 'choice'])
                ->where("user_id", auth()->user()->id);
        }]);
        
        // dd($data['data_studentanswers']);

        return view($page, $data);
    }
}
