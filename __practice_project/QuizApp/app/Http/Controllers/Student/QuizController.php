<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StudentQuestionAnswer;
use App\Models\StudentQuestionSortOrder;
use App\Models\StudentQuizDetails;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // List of Quizzes
    public function index() {
        $data = array();
        $data["data_datarecordfile"] = Quiz::with(['user'])->get();
        $data['title'] = "Student QuizzApp";
        $data['page'] = "Dashboard";
        $data["user_type"] = auth()->user()->user_type;
        $page = "student.index";

        return view($page, $data);
    }

    // View the single Quiz
    public function view(Quiz $quiz) {
        
        $page = "student.quiz.view";

        $data = array();

        $userId = auth()->user()->id;
        $data["quiz_id"] = $quiz->id;
        $data["data_dataactivepage"] = "student_quiz_view";
        $data["data_datarecordfile"] = $quiz->load(['latest_student_quiz_details' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);

        $data["data_startDate"] = date('F j, h:i a', strtotime($data["data_datarecordfile"]["start_date"]));
        $data["data_endDate"] = date('F j, h:i a', strtotime($data["data_datarecordfile"]["end_date"]));

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

        // set is submission is still allowed
        $data["data_isSubmissionAllowed"] = false;

        $data["data_isQuizOpen"] = $this->isQuizOpen($quiz);

        // check if quiz start or not
        $data["data_isQuizStart"] = $this->isQuizStarted($quiz);
        $data["data_isQuizEnd"] = $this->isQuizEnd($quiz);

        $data["data_hasResults"] = count($data["data_datarecordfile"]->student_quiz_details) > 0 ? true : false;
        $data["data_isOngoing"] = null;

        if($data["data_hasResults"]) {
            // set the total score
            $data["data_totalQuestions"] = Question::where("quiz_id", $data["quiz_id"])
                ->count();

            $quizPoints = ($quiz->points != null)  ? $quiz->points : 1;
            $data["data_totalQuizPoints"] = $data["data_totalQuestions"] * ($quizPoints);
    
            $data["data_studentQuizScore"] = isset($latestStuentQuizDetails->id) ? $latestStuentQuizDetails->score : null;
    
            if($latestStuentQuizDetails->review_status == "ongoing") {
                $data["data_isOngoing"] = true;
            } else if($latestStuentQuizDetails->review_status == "finished") {
                $data["data_isOngoing"] = false;
            }

            
        }

        // dd($data["data_datarecordfile"], $studentAttempts, $quizAttempts, $data["data_isMaxAttemptReach"], $data["data_hasResults"], $data["data_studentQuizScore"]);

        return view($page, $data);
    }

    // Start the quiz
    public function startQuiz(Quiz $quiz) {

        // $page = "student.quiz.questions";
        // $data = array();
        $currentQuestion = array();

        $questions = $quiz->questions()->get();
        $userId = auth()->user()->id;

        $randNumberArr = array();

        $hasQuestionOrder = StudentQuestionSortOrder::where('quiz_id', $quiz->id)
            ->where("user_id", $userId);

        if ($hasQuestionOrder->exists()) {
            $hasQuestionOrder->delete();
        }

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

        // dd($currentQuestion);
       

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

    // Resumt the quiz
    public function resumeQuiz(Quiz $quiz) {
        $currentQuestion = array();
        
        // FIX ME
        $lastQuestionId = $quiz->latest_student_quiz_details()->pluck('last_question_id');
        $currentQuestion = Question::find($lastQuestionId)->first();

        return redirect()->route('student.quiz.question', $currentQuestion);
        
    }

    // Reattempt of Quiz
    public function reattemptQuiz(Quiz $quiz) {
        $currentQuestion = array();

        $userId = auth()->user()->id;

        // get the previous_quiz_details attempts

        $lastQuizAttempt = $quiz->latest_student_quiz_details()->value('attempts');

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
            "attempts" => $lastQuizAttempt + 1,
            "last_question_id" => $currentQuestion->id,
            "started_at" => $dt
        ];

        $result = StudentQuizDetails::create($xarr_param);

        return redirect()->route('student.quiz.question', $currentQuestion);
    }

    /**
     * Controller inside functions
     */
    function isQuizOpen(Quiz $quiz) {
        $currentDate = Carbon::now();
        $currentDate = $currentDate->toDateTimeString();
        
        $quizStart = $quiz->start_date;
        $quizEnd = $quiz->end_date;
        $quizAllowLate = $quiz->allow_late;

        $isWithinRange = ($currentDate >= $quizStart) && ($currentDate <= $quizEnd);
        $isAllowedLate = ($currentDate >= $quizStart) && $quizAllowLate;
        
        if($isWithinRange || $isAllowedLate) {
            return true;
        } else {
            return false;
        }
    }

    function isQuizStarted(Quiz $quiz) {
        $currentDate = Carbon::now();
        $currentDate = $currentDate->toDateTimeString();

        $quizStart = $quiz->start_date;

        $isWithinRange = ($currentDate >= $quizStart);


        if($isWithinRange) {
            return true;
        } else {
            return false;
        }

    }

    function isQuizEnd(Quiz $quiz) {
        $currentDate = Carbon::now();
        $currentDate = $currentDate->toDateTimeString();

        $quizEnd = $quiz->end_date;


        $isWithinRange = ($currentDate >= $quizEnd);


        if($isWithinRange) {
            return true;
        } else {
            return false;
        }

    }

    function checkIsAValidDate($myDateString){
        return (bool)strtotime($myDateString);
    }
}