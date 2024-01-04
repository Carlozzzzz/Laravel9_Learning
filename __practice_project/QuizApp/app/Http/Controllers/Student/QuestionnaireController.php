<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\User;
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
    
    // TODO*  refactor this
    public function getQuestion(Question $question) {
        
        $page = "student.quiz.questions";
        $data = array();

        $data['data_dataactivepage'] = "student_quiz_question";
        $data['data_currentquestion'] = $question->load(['student_question_sort_order' => function($query) {
            $query->where('user_id', auth()->user()->id);
        }]);

        $quiz = $question->quiz()->first();

        $data['data_quiz'] = $quiz;
        $data['data_questions'] = Question::whereHas('student_question_sort_order', function($query) {
                        $query->where('user_id', auth()->user()->id);
                        })
                ->where('quiz_id', $quiz->id)
                ->with(['student_question_sort_order'])
                ->get()
                ->sortBy('student_question_sort_order.question_order');

        return view($page, $data);
    }

    public function getQuestionnaire(Question $question) {

        $xdata = array();
        $quizId = $question->quiz_id;
        $currentUser = auth()->user();

        $currrentQuestion = $question->load(['student_question_sort_order' => function($query) {
            $query->where('user_id', auth()->user()->id);
        }, 'choices']);

                
        $currentOrder = $currrentQuestion->student_question_sort_order->question_order;
        $prevQuestionOrder = $currentOrder - 1;
    
        $prevQuestion = $nextQuestion = Question::whereHas('student_question_sort_order', function($query) use ($currentUser, $prevQuestionOrder) {
            $query->where('user_id', $currentUser->id)
                ->where('question_order', $prevQuestionOrder);
        })->with('choices')->first();

        $nextQuestionOrder = $currentOrder + 1;

        $nextQuestion = $nextQuestion = Question::whereHas('student_question_sort_order', function($query) use ($currentUser, $nextQuestionOrder) {
            $query->where('user_id', $currentUser->id)
                ->where('question_order', $nextQuestionOrder);
        })->with('choices')->first();

        $xdata['data']['question_order'] = $currentOrder;
        $xdata['data']['current_questionnaire'] = $currrentQuestion;
        $xdata['data']['prev_questionnaire'] = $prevQuestion;
        $xdata['data']['next_questionnaire'] = $nextQuestion;
        $xdata['data']['quiz'] = Quiz::with(['questions'])
                ->where('id', $quizId)
                ->first();

        return response()->json($xdata, 200);
    }

    public function prevOrNextQuestionnaire(Question $question) {
        $xdata = array();

        
        $currrentQuestion = Question::with(['choices', 'student_question_sort_orders'])->find($question->id);
        $nextQuestion = $question->with(['choices', 'student_question_sort_orders'])->where('id', '>', $currrentQuestion->id)->orderBy('id','asc')->first();
        $prevQuestion = $question->with(['choices', 'student_question_sort_orders'])->where('id', '<', $currrentQuestion->id)->orderBy('id','desc')->first();
        
        $xdata['data']['current_questionnaire'] = $currrentQuestion;
        $xdata['data']['prev_questionnaire'] = $prevQuestion;
        $xdata['data']['next_questionnaire'] = $nextQuestion;

        // return response()->json($xdata, 200);
        return response()->json($xdata, 200);
    }

}
 