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
    // TODO*  refactor this
    public function viewQuestion(Question $question) {
        
        $page = "student.quiz.questions";
        $data = array();

        $userId = auth()->user()->id;

        $data['data_dataactivepage'] = "student_quiz_question";
        $data['data_currentquestion'] = $question->load(['student_question_sort_order' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);

        $quiz = $question->quiz()->first();

        $data['data_quiz'] = $quiz->load(['student_quiz_details' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);

        $data['data_questions'] = Question::whereHas('student_question_sort_order', function($query) {
                        $query->where('user_id', auth()->user()->id);
                        })
                ->where('quiz_id', $quiz->id)
                ->with(['student_question_sort_order','student_quiz_answers'])
                ->get()
                ->sortBy('student_question_sort_order.question_order');

        // dd($data['data_questions']);

        return view($page, $data);
    }

    public function getQuestionnaire(Question $question) {

        $xdata = array();
        $quizId = $question->quiz_id;
        $currentUser = auth()->user();

        $currrentQuestion = $question->load(['student_question_sort_order' => function($query) {
            $query->where('user_id', auth()->user()->id);
        }, 'choices', 'student_quiz_answers']);

        // Updating last question id
        $xarr_param = array();
        $xarr_param = [
            'last_question_id' => $currrentQuestion->id,
            'user_id' => $currentUser->id
        ];
        $quiz = Quiz::with(['student_quiz_details'])->find($question->quiz_id);
        $quiz->student_quiz_details()->update($xarr_param);
                
        // Get the sort order to fetch prev and next question
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
}   