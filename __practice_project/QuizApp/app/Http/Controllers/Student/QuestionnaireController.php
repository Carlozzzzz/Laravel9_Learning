<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\StudentQuestionSortOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    // TODO*  refactor this
    public function viewQuestion(Question $question) {
        
        $page = "student.quiz.questions";
        $data = array();
        $quizId = $question->quiz_id;
        $quiz = Quiz::with(['latest_student_quiz_details'])->find($quizId);
        $latestQuizDetails = $quiz->latest_student_quiz_details;
        if(isset($latestQuizDetails->review_status) && $latestQuizDetails->review_status == "finished") {
            return redirect()->route('student.quiz.view', $quizId);
        }

        $latestQuizDetailsId = $latestQuizDetails->id;
        $userId = auth()->user()->id;

        $data['data_dataactivepage'] = "student_quiz_question";
        $data['data_currentquestion'] = $question->load(['student_question_sort_order' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);

        $quiz = $question->quiz()->first();

        $data['data_quiz'] = $quiz->load(['latest_student_quiz_details' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);

        // $data['data_questions'] = Question::whereHas('student_question_sort_order', function($query) use ($userId) {
        //                     $query->where('user_id', $userId)
        //                         ->orderBy('question_order');
        //                 })
        //         ->where('quiz_id', $quiz->id)
        //         ->with(['student_question_sort_order','student_quiz_answers' => function($query) use($userId, $latestQuizDetailsId) {
        //                     $query->where("student_quiz_details_id", $latestQuizDetailsId)
        //                         ->where("user_id", $userId);
        //                 }])
        //         ->get();

        // $data['data_questions'] = Question::with(['student_question_sort_order','student_quiz_answers' => function($query) use($userId, $latestQuizDetailsId) {
        //         $query->where("student_quiz_details_id", $latestQuizDetailsId)
        //             ->where("user_id", $userId);
        //     }])
        //     ->leftJoin('student_question_sort_orders', 'questions.id', '=', 'student_question_sort_orders.question_id')
        //     ->where('questions.quiz_id', $quizId)
        //     ->where('student_question_sort_orders.user_id', $userId)
        //     ->orderBy('student_question_sort_orders.question_order')
        //     ->get();

        // $data['data_questions'] = DB::table("questions")
        //     ->join('student_question_sort_orders', function($join) use($quizId) {
        //         $join->on('questions.id', '=', 'student_question_sort_orders.question_id')
        //             ->where('student_question_sort_orders.quiz_id', '=', $quizId);
        //     })
        //     ->join('student_quiz_answers', function($join) use($userId, $quizId) {
        //         $join->on('questions.id', '=', 'student_quiz_answers.question_id')
        //             ->where('user_id', $userId);
        //     })
        //     ->where('user_id', '=', $userId)
        //     ->orderBy('question_order')
        //     ->get();

        $data['data_questionsSortOrder'] = StudentQuestionSortOrder::with(['question' => function($query) use($latestQuizDetailsId){
                $query->with(['student_quiz_answers' => function($query2) use($latestQuizDetailsId) {
                    $query2->where('student_quiz_details_id', $latestQuizDetailsId);
                }]);
            }])
            ->where("quiz_id", $quizId)
            ->where("user_id", $userId)
            ->orderBy("question_order")
            ->get();

        return view($page, $data);
    }

    public function getQuestionnaire(Question $question, Request $request) {

        $xdata = array();
        $quizId = $question->quiz_id;
        $quiz = Quiz::with(['latest_student_quiz_details'])->find($quizId);
        $latestQuizDetailsId = $quiz->latest_student_quiz_details->id;
        $userId = auth()->user()->id;


        $currrentQuestion = $question->load(['student_question_sort_order' => function($query) {
            $query->where('user_id', auth()->user()->id);
        }, 'choices', 'student_quiz_answers' => function($query) use($latestQuizDetailsId) {
            $query->where("student_quiz_details_id", $latestQuizDetailsId);
        }]);


        // Updating last question id
        $xarr_param = array();
        $xarr_param = [
            'last_question_id' => $currrentQuestion->id,
            'user_id' => $userId
        ];

        $quiz->student_quiz_details()->update($xarr_param);
                
        // Get the sort order to fetch prev and next question
        $currentOrder = $currrentQuestion->student_question_sort_order->question_order;
        $prevQuestionOrder = $currentOrder - 1;
    
        $prevQuestion = Question::whereHas('student_question_sort_order', function($query) use ($userId, $prevQuestionOrder) {
                $query->where('user_id', $userId)
                    ->where('question_order', $prevQuestionOrder);
            })
            ->where('quiz_id', $quizId)
            ->with('choices')->first();

        // dd($prevQuestion);

        $nextQuestionOrder = $currentOrder + 1;

        $nextQuestion = Question::whereHas('student_question_sort_order', function($query) use ($userId, $nextQuestionOrder) {
                    $query->where('user_id', $userId)
                        ->where('question_order', $nextQuestionOrder);
                })
            ->where("quiz_id", $quizId)    
            ->first();

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