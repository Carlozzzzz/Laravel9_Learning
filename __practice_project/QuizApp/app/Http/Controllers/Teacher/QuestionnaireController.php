<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use App\Models\Answer;
use App\Models\Choice;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class QuestionnaireController extends Controller
{
    public function index(Quiz $quiz) {
        $page = "teacher.quiz.add_edit";
        if(View::exists($page)) {
            $data = array();
            $data['title'] = "Quiz";
            $data['page'] = "Quiz";
            
            $data["data_dataactivepage"] = "teacher_quiz_question";
            $data["data_datarecordfile"] =  $quiz;
            return view($page, $data);

        } return abort(404);

    }

    public function getQuestionnaire(Quiz $quiz) {
        $xdata = array();
        $xdata['data'] = Question::with(['choices', 'answers'])->where('quiz_id', $quiz->id)->get();

        return response()->json($xdata, 200);
    }

    public function store(Quiz $quiz, QuestionnaireRequest $request)
    {                
        $validated = $request->validated();

        $category = $validated["category"];

        $xretobj = array();
        $xdata = array();

        $questionData = $quiz->questions()->createQuietly($validated);

        $xdata["category"] = $validated["category"];
        $xdata["id"] = $questionData->id;
        $xdata["question"] = $questionData->question;

        if($category == "multiple_choice" || $category == "true_or_false") {


            foreach ($validated['choice'] as $choice => $value) {
                $choiceData = $questionData->choices()->createQuietly(["choice" => $value]);
                $choiceValue = $value;
                $xdata["choices"][] = $choiceData;

                if ($choice == $validated["answer_key"]) {
                    $answerValue = $value;
                    $xarr_param = [
                        "question_id" => $questionData->id,
                        "answer" => $answerValue,
                    ];

                    $answerData = $choiceData->answers()->createQuietly($xarr_param);

                    $xdata['answers'][] = $answerData;
            
                }
            }


        } else if($category == "checklist" || $category == "enumeration") {

            $xdata["choices"] = array();
            $xdata["answer_key"] = array();

            foreach ($validated["choice"] as $choice => $value) {
                $choiceData = $questionData->choices()->createQuietly(["choice" => $value]);
                $xdata['choices'][] = $choiceData;

                if($category == "checklist") {
                    if (isset($validated["answer_key"]) && is_array($validated["answer_key"])) {
                        $isAnswerKey = in_array($choice, $validated["answer_key"]);
                        if ($isAnswerKey) {
                            $xarr_param = [
                                "question_id" => $questionData->id,
                                "choice_id" => $choiceData->id,
                                "answer" => $choice,
                            ];

                            $answerData = $choiceData->answers()->createQuietly($xarr_param);
                            $xdata["answers"][] = $answerData;
                           
                        }
                    }
                }
            }
        }

        
        // $xretobj["data"] = $xdata;
        $xretobj["data"] = $xdata;

        $xretobj["message"] = "Question created successfully!";

        return response()->json($xretobj, 200);
    }

    // working
    public function update(Quiz $quiz, QuestionnaireRequest $request)
    {

        $xretobj = array();
        $xdata = array();

        $validated = $request->validated();

        $category = $validated["category"];
        $questionId = $validated["question_id"];

        $xdata["category"] = $validated["category"];

        $questionData = Question::where("id", $questionId)->first();
        $questionData->question = $validated["question"];
        $questionData->save();

        $questionId = $questionData->id;
        $question = $questionData->question;

        // Question Details
        $xdata["id"] = $questionId;
        $xdata["question"] = $question;

        if($category == "multiple_choice" || $category == "true_or_false") {

            $choiceIdArr = array();
            $choiceIdArr = $validated["choiceId"];

            foreach ($validated['choice'] as $choice => $value) {
                $choiceKeyId = $choice . "_id";
                $choiceId = $choiceIdArr[$choiceKeyId];

                $choiceData = Choice::where("id", $choiceId)->first();
                $choiceData->choice = $value;
                $choiceData->save();
                
                // Choices details
                $choiceId = $choiceData->id;
                $choiceValue = $value;

                $xdata["choices"][] = $choiceData;

                // update the answer here
                $answerKey = $validated["answer_key"];

                if($answerKey == $choice) {
                    $answerData = Answer::where('question_id', $questionId)->first();
                    $answerData->choice_id = $choiceId;
                    $answerData->answer = $choiceValue;
                    $answerData->save();

                    // return data
                    $xdata["answers"][] = $answerData;
                }
            }

        }

        if($category == "checklist" || $category == "enumeration") {

            $choiceIdArr = $validated["choiceId"];

            foreach ($validated['choice'] as $choice => $choiceValue) {
                $choiceKeyId = $choice . "_id";
                $choiceId;
                $choiceData;

                $inChoiceArr = $choiceIdArr[$choiceKeyId] ?? null;

                if($inChoiceArr) {
                    $choiceId = $choiceIdArr[$choiceKeyId];

                    // Refactor to creating | updating of data
                    $choiceData = Choice::where("id", $choiceId)->first();
                    $choiceData->choice = $choiceValue;
                    $choiceData->save();
                } else {

                    $choiceData = $questionData->choices()->createQuietly(["choice" => $choiceValue]);
                }
                
                // Choices details
                $choiceId = $choiceData->id;
                $xdata["choices"][] = $choiceData;

                // update the answer here
                if($category == "checklist" && isset($validated["answer_key"])) {

                    $answerKeyArr = $validated["answer_key"];
                    $answerKeyIdArr = [];

                    foreach ($answerKeyArr as $answer => $answerValue) {
                        if($answerValue == $choice) {
                            $answerData = Answer::where('choice_id', $choiceId)->first();
                            if($answerData) {
                                $answerData->answer = $choice;
                                $answerData->save();
                            } else {
                                $xarr_param = [
                                    "question_id" => $questionId,
                                    "answer" => $choice,
                                ];
                                $answerData = $choiceData->answers()->createQuietly($xarr_param);
                            }
    
                            $answerValue = $answerData->answer;
                            $xdata["answers"][] = $answerData;
                        }
                    }

    
                    foreach($answerKeyArr as $answer => $answerValue) {
                        $choiceKeyId = $answerValue . "_id";
                        $choiceId = $choiceIdArr[$choiceKeyId];
                        $answerKeyIdArr[] = $choiceId;
                    }

                    $answerData = Answer::where('question_id', $questionId)->get();
                    foreach($answerData as $key => $value) {
                        $wasFound = in_array($value->choice_id, $answerKeyIdArr);
                        if (!$wasFound) { 
                            Answer::where("choice_id", $value->choice_id)->delete(); 
                        }
                    }
                }

    
            }

            // update the removed answer
        }

        // dd($xdata);

        $xretobj["data"] = $xdata;
        $xretobj["message"] = "Question updated successfully!";

        return response()->json($xretobj, 200);

    }

    public function delete(Question $question)
    {
        $questionData = $question->delete();

        $xretobj["message"] = "Question deleted successfully!";

        return response()->json($xretobj, 200);
    }
}