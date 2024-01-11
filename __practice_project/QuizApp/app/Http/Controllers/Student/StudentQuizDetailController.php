<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentQuizAnswer;
use App\Models\StudentQuizDetails;
use Illuminate\Http\Request;

class StudentQuizDetailController extends Controller
{
    public function updateTimer(StudentQuizDetails $studentQuizDetails, Request $request) {
        $xdata = array();

        $validated = $request->validate([
            'hours' => 'required',
            'minutes' => 'required',
            'seconds' => 'required',
        ]);

        $xdata["data"] = $studentQuizDetails->update($validated);

        return response()->json($xdata);
    }

    public function createResult(StudentQuizDetails $studentQuizDetails, Request $request) {
        $userId = auth()->user()->id;
        $xdata = array();

        // get the quiz details
        // $quiz = $studentQuizDetails->quiz()->with(['questions.answers'])->first();
        
        $quizPoints = (int)$studentQuizDetails->quiz()->value('points');

        $answers = $studentQuizDetails->quiz()
            ->join('questions', 'quiz_id', '=', 'questions.quiz_id')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->select('answers.*')
            ->get();

        // get the user answer for the specified quiz
        // $studentQuizDetails = $studentQuizDetails->with('student_quiz_answer')->get();
        $studentQuizAnswers = $studentQuizDetails->student_quiz_answer()->get();


        // Check the answers per queston if match to the correct answer
        // echo "<pre>";
    
        $score = 0;
        $total_points = (count($answers) * $quizPoints);

        foreach($answers as $answer) {
            foreach($studentQuizAnswers as $studentAnswer){
                
                if($answer->question_id == $studentAnswer->question_id) {
                    // echo "KEY: " . $answer->choice_id . " => " . $studentAnswer->choice_id . "<br>";
                    $xarr_param = array();
                    $points = $quizPoints;
                    if($answer->choice_id == $studentAnswer->choice_id) {
                        $studentQuizAnswer = StudentQuizAnswer::where('question_id', $studentAnswer->question_id)
                            ->where('choice_id', $studentAnswer->choice_id)
                            ->where('user_id', $userId);
                        
                        $xarr_param = [
                            'is_correct' => true,
                            'point' => $points
                        ];

                        $studentQuizAnswer->update($xarr_param);

                        $score += $points;
                    } else {
                        $studentQuizAnswer = StudentQuizAnswer::where('question_id', $studentAnswer->question_id)
                            ->where('choice_id', $studentAnswer->choice_id)
                            ->where('user_id', $userId);
                        $xarr_param = [
                            'is_correct' => false,
                            'point' => 0
                        ];
                        
                        // echo "\tWrong<br>";
                    }
                    $xarr_param['points_per_question'] = $points;
                    $studentQuizAnswer->update($xarr_param);
                }
            }

            $studentQuizDetails->update(['score' => $score, 'total_points' => $total_points]);
        }

        $xdata['message'] = "Results has been generated.";


        // echo "</pre>";
        
        // update the finished time
        // increment quizDetails score each time the answer is correct (if the points is defined on quiz, use the points there)
        //

        // dd($answers, $studentQuizAnswers);
        return response()->json($xdata);

        // return redirect()->route('student.quizresult.result', $studentQuizDetails->id);
    }
}
