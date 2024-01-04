<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StudentQuestionAnswer;
use App\Models\StudentQuestionSortOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index() {
        $data = array();
        $data["data_datarecordfile"] = Quiz::with(['user'])->get();
        $data['title'] = "Student QuizzApp";
        $data['page'] = "Dashboard";
        $data["user_type"] = auth()->user()->user_type;
        $page = "student.index";

        return view($page, $data);
    }

    public function view(Quiz $quiz) {
        
        $page = "student.quiz.view";

        $data = array();
        // $data = Quiz::with(['user'])->get();
        $data["quiz_id"] = $quiz->id;
        $data["data_datarecordfile"] = $quiz;
        $data["data_dataactivepage"] = "student_quiz_view";

        // dd($data);
        return view($page, $data);
    }

    public function startQuiz1(Quiz $quiz) {

        // $page = "student.quiz.questions";
        $data = array();
        $firstQuestion = array();

        $questions = $quiz->questions()->get();

        $randNumberArr = array();

        $hasQuestionOrder = StudentQuestionSortOrder::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->user()->id)
            ->exists();


        if(!$hasQuestionOrder) {
            foreach($questions as $question) {
                // echo "Question : " . $question->id . "<br>";
                $xarr_param = array();
                $questionLength = count($questions);
    
                do {
                    $randomNumber = rand(1,$questionLength);
                } while (in_array($randomNumber, $randNumberArr));
    
                $xarr_param = [
                    "user_id" => auth()->user()->id,
                    "question_id" => $question->id,
                    "quiz_id" => $quiz->id,
                    "question_order" => $randomNumber
                ];
    
                array_push($randNumberArr, $randomNumber);
    
                StudentQuestionSortOrder::create($xarr_param);
                
                if($randomNumber == 1) {
                    $firstQuestion = $question;
                    // $data["data"]["current_question"] = $question;
                }
            }
        } else {
                // $data["data"]["current_question"] = Question::whereHas('student_question_sort_order', function($query) {
                //     $query->where('question_order', 1);
                // })->with(['choices', 'student_question_sort_order'])->first();

                $firstQuestion = Question::whereHas('student_question_sort_order', function($query) {
                        $query->where('question_order', '=', 1)->where('user_id', auth()->user()->id);
                        })
                    ->first();
        }

        return redirect()->route('student.quiz.question', $firstQuestion);
        // return view($page, $data);
    }

    public function startQuiz(Quiz $quiz) {

        $xdata = array();
        $questions = $quiz->questions()->get();
        $firstQuestion = array();

        $randNumberArr = array();

        foreach($questions as $question) {
            // echo "Question : " . $question->id . "<br>";
            $xarr_param = array();
            $questionLength = count($questions);

            do {
                $randomNumber = rand(1,$questionLength);
            } while (in_array($randomNumber, $randNumberArr));

            $xarr_param = [
                "question_id" => $question->id,
                "user_id" => auth()->user()->id,
                "question_order" => $randomNumber
            ];

            array_push($randNumberArr, $randomNumber);

            $result = StudentQuestionSortOrder::create($xarr_param);
            
            if($randomNumber == 1) {
                $xdata["data"]["current_question"] = $question;
            }
        }

        $xdata["data"]["questions"] = $questions;

        dd($xdata["data"]["current_question"]);
        return response()->json($xdata, 200);
    }

}
