<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    // TODO** refactor this and its dependencies
    public function viewQuestion(Quiz $quiz) {
        $page = "student.quiz.questions";
        $data['data_dataactivepage'] = "student_quiz_question";
        $data['data_quiz'] = $quiz;
        $data['quiz_id'] = $quiz->id;

        return view($page, $data);
    }
    public function getQuestionnaire(Quiz $quiz) {
        $page = "student.quiz.questions";

        $xdata = array();

        // check if the quiz is set to randomize question
        // if true
                // get the first question with queston_order of 1
                // it should be the question without answer, for instance of the quizzer needed to continue the quiz
        // else 
                // get the question 



        $isRandomizeQuestion = $quiz->randomize_question;
        if($isRandomizeQuestion == 1) {
            // first question without answer
            $noAnswerQuestion = Question::with(['choices'])
                ->where("quiz_id", $quiz->id)
                ->first();
            dd("No answers", $noAnswerQuestion);
        } else {
            echo "Normal selecting of question";
        }

        dd("End DD");

        $currrentQuestion = $quiz->questions()
            ->join('student_question_sort_orders', 'questions.id', '=', 'student_question_sort_orders.question_id')
            ->where('questions.quiz_id', $quiz->id)
            ->orderBy('student_question_sort_orders.question_order')
            ->select('questions.*') // Select only the columns from the questions table
            ->with(['choices', 'student_question_sort_orders'])
            ->first();
    
        $currentOrder = $currrentQuestion->student_question_sort_orders->question_order;
    
        $nextQuestion = $quiz->questions()
            ->whereHas('student_question_sort_orders', function ($query) use ($currentOrder) {
                $query->where('question_order','>', $currentOrder);
            })
            ->with(['choices', 'student_question_sort_orders'])
            ->first();

        $prevQuestion = $quiz->questions()
            ->whereHas('student_question_sort_orders', function ($query) use ($currentOrder) {
                $query->where('question_order','<', $currentOrder);
            })
            ->with(['choices', 'student_question_sort_orders'])
            ->first();
            
        // $prevQuestion = $quiz->questions()->with(['choices'])->where('id', '<', $currrentQuestion->id)->first();
        
        $xdata['data']['current_questionnaire'] = $currrentQuestion;
        $xdata['data']['prev_questionnaire'] = $prevQuestion;
        $xdata['data']['next_questionnaire'] = $nextQuestion;
        
        return response()->json($xdata, 200);
    }

    public function prevQuestionnaire(Question $question) {
        $xdata = array();

        $currrentQuestion = $question->with(['choices'])->findOrFail($question->id);
        $prevQuestion = $question->with(['choices'])->where('id', '<', $currrentQuestion->id)->first();
        $nextQuestion = $question->with(['choices'])->where('id', '>', $currrentQuestion->id)->first();
        
        $xdata['data']['current_questionnaire'] = $currrentQuestion;
        $xdata['data']['prev_questionnaire'] = $prevQuestion;
        $xdata['data']['next_questionnaire'] = $nextQuestion;

        return response()->json($xdata, 200);
    }

    public function nextQuestionnaire(Question $question) {
        $xdata = array();

       

        // $currrentQuestion = $question->with(['choices'])->findOrFail($question->id);
        $currrentQuestion = $question
            ->with(['choices', 'student_question_sort_orders'])
            ->first();

        $currentOrder = $currrentQuestion->student_question_sort_orders->question_order;

        if($currentOrder == 3) {
            dd($currrentQuestion);
        }
        // $prevQuestion = $question->with(['choices'])->where('id', '<', $currrentQuestion->id)->first();
        $prevQuestion = Question::whereHas('student_question_sort_orders', function ($query) use ($currentOrder) {
                $query->where('question_order','<', $currentOrder);
            })
            ->with(['choices', 'student_question_sort_orders'])
            ->first();
        
        // $nextQuestion = $question->with(['choices'])->where('id', '>', $currrentQuestion->id)->first();
        $nextQuestion = Question::whereHas('student_question_sort_orders', function ($query) use ($currentOrder) {
                $query->where('question_order','>', $currentOrder);
            })
            ->with(['choices', 'student_question_sort_orders'])
            ->first();
        
        $xdata['data']['current_questionnaire'] = $currrentQuestion;
        $xdata['data']['prev_questionnaire'] = $prevQuestion;
        $xdata['data']['next_questionnaire'] = $nextQuestion;

        return response()->json($xdata, 200);
    }

    public function randomizeQuestinonnaire(Question $question) {

    }
}
