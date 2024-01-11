<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StudentQuestionAnswer;
use App\Models\StudentQuestionSortOrder;
use App\Models\StudentQuizDetails;
use DateTime;
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

        $userId = auth()->user()->id;
        $data["quiz_id"] = $quiz->id;
        $data["data_dataactivepage"] = "student_quiz_view";
        $data["data_datarecordfile"] = $quiz->load(['latest_student_quiz_details' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);

        // dd($userId, $data["data_datarecordfile"]);

        $quizAttempts = (int)$quiz->attempts;
        $latestStuentQuizDetails = $data["data_datarecordfile"]->latest_student_quiz_details ?? null;

        $studentAttempts = $latestStuentQuizDetails->attempts ?? 0;
        $data["data_studentAttempts"] = $studentAttempts;

        if($studentAttempts >= $quizAttempts) {
            $data["data_isMaxAttemptReach"] = true;
        } else {
            $data["data_isMaxAttemptReach"] = false;
        }
        
        $data["data_hasResults"] = count($data["data_datarecordfile"]->student_quiz_details) > 0 ? true : false;
        $data["data_isOngoing"] = null;

        // set the total score
        if($data["data_hasResults"]) {
            $data["data_totalQuestions"] = Question::where("quiz_id", $data["quiz_id"])
                ->count();

            $quizPoints = ($quiz->points != null)  ? $quiz->points : 1;
            $data["data_totalQuizPoints"] = $data["data_totalQuestions"] * ($quizPoints);
    
            $data["data_studentQuizScore"] = isset($latestStuentQuizDetails->id) ? $latestStuentQuizDetails->score * $quizPoints : null;
    
            if($latestStuentQuizDetails->review_status == "ongoing") {
                $data["data_isOngoing"] = true;
            } else if($latestStuentQuizDetails->review_status == "finished") {
                $data["data_isOngoing"] = false;
            }
        }

        // dd($data["data_datarecordfile"], $studentAttempts, $quizAttempts, $data["data_isMaxAttemptReach"], $data["data_hasResults"], $data["data_studentQuizScore"]);

        return view($page, $data);
    }

    public function startQuiz(Quiz $quiz) {

        // $page = "student.quiz.questions";
        // $data = array();
        $currentQuestion = array();

        $questions = $quiz->questions()->get();
        $userId = auth()->user()->id;

        $randNumberArr = array();

        foreach($questions as $question) {
            // echo "Question : " . $question->id . "<br>";
            $xarr_param = array();
            $questionLength = count($questions);

            do {
                $randomNumber = rand(1,$questionLength);
            } while (in_array($randomNumber, $randNumberArr));

            $xarr_param = [
                "user_id" => $userId,
                "question_id" => $question->id,
                "quiz_id" => $quiz->id,
                "question_order" => $randomNumber
            ];

            array_push($randNumberArr, $randomNumber);

            StudentQuestionSortOrder::create($xarr_param);
            
            if($randomNumber == 1) {
                $currentQuestion = $question;
                // $data["data"]["current_question"] = $question;
            }
        }

        $xarr_param = array();
        $dt = new DateTime();
        $dt->format('Y-m-d H:i:s');

        $xarr_param = [
            "quiz_id" => $quiz->id,
            "user_id" => $userId,
            "hours" => $quiz->time_limit_hr,
            "minutes" => $quiz->time_limit_mm,
            "seconds" => $quiz->time_limit_sec,
            "review_status" => "ongoing",
            "attempts" => 1,
            "last_question_id" => $currentQuestion->id,
            "started_at" => $dt
        ];

        StudentQuizDetails::create($xarr_param);

        return redirect()->route('student.quiz.question', $currentQuestion);
    }

    public function resumeQuiz(Quiz $quiz) {
        $currentQuestion = array();
        
        // FIX ME
        $lastQuestionId = $quiz->latest_student_quiz_details()->pluck('last_question_id');
        $currentQuestion = Question::find($lastQuestionId)->first();

        return redirect()->route('student.quiz.question', $currentQuestion);
        
    }

    public function reattemptQuiz(Quiz $quiz) {
        $currentQuestion = array();

        $userId = auth()->user()->id;


        $currentQuestion = Question::whereHas('student_question_sort_order', function($query) use($userId) {
            $query->where('question_order', 1)
                ->where('user_id', $userId);
        })->first();
        
        $xarr_param = array();
        $dt = new DateTime();
        $dt->format('Y-m-d H:i:s');

        $xarr_param = [
            "quiz_id" => $quiz->id,
            "user_id" => $userId,
            "hours" => $quiz->time_limit_hr,
            "minutes" => $quiz->time_limit_mm,
            "seconds" => $quiz->time_limit_sec,
            "review_status" => "ongoing",
            "attempts" => 1,
            "last_question_id" => $currentQuestion->id,
            "started_at" => $dt
        ];

        $result = StudentQuizDetails::create($xarr_param);

        return redirect()->route('student.quiz.question', $currentQuestion);
    }
}