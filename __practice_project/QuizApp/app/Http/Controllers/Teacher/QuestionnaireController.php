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
use Illuminate\Validation\Rule;

class QuestionnaireController extends Controller
{
    public function store(Quiz $quiz, QuestionnaireRequest $request)
    {                
        $validated = $request->validated();

        $category = $validated["category"];

        $xretobj = array();
        $xdata = array();

        $questionData = $quiz->questions()->createQuietly($validated);

        $xdata["category"] = $validated["category"];
        $xdata["question"] = array();
        $xdata["question"][] = [
            "id" => $questionData->id,
            "value" => $questionData->question
        ];

        if($category == "multiple_choice" || $category == "true_or_false") {

            $xdata["choices"] = array();
            $xdata["answer_key"] = array();

            foreach ($validated['choice'] as $choice => $value) {
                $choiceData = $questionData->choices()->createQuietly(["choice" => $value]);
                $choiceValue = $value;
                $xdata['choices'][] = [
                    "id" => $choiceData->id,
                    "name" => $choice,
                    "value" => $choiceValue,
                ];

                if ($choice == $validated["answer_key"]) {
                    $answerValue = $value;
                    $xarr_param = [
                        "question_id" => $questionData->id,
                        "answer" => $answerValue,
                    ];

                    $answerData = $choiceData->answers()->createQuietly($xarr_param);

                    $xdata['answer_key'][] = [
                        "id" => $answerData->id,
                        "name" => $choice,
                        "value" => $answerValue,
                    ];
            
                }
            }

        } else if($category == "checklist" || $category == "enumeration") {

            $xdata["choices"] = array();
            $xdata["answer_key"] = array();

            foreach ($validated["choice"] as $choice => $value) {
                $choiceData = $questionData->choices()->createQuietly(["choice" => $value]);
                
                $xdata['choices'][] = [
                    "id" => $choiceData->id,
                    "name" => $choice,
                    "value" => $value,
                ];

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

                            $xdata['answer_key'][] = [
                                "id" => $answerData->id,
                                "name" => $choice,
                                "value" => $answerData->answer,
                            ];
                        }
                    }
                }
            }
        }

        // $xtestdata = array();
        // $xtestdata = Question::with(['choices', 'answers'])->find(559);

        $xretobj["data"] = $xdata;
        $xretobj["message"] = "Question created successfully";

        return response()->json($xretobj, 200);
    }

    // working , fix answerID save and update
    public function update(Quiz $quiz, QuestionnaireRequest $request){

        $validated = $request->validated();

        $category = $validated["category"];
        $questionId = $validated["question_id"];

        $xretobj = array();
        $xdata = array();

        $xdata["category"] = $validated["category"];

        $questionData = Question::where("id", $questionId)
            ->first();

        $questionData->question = $validated["question"];

        $questionData->save();

        $questionId = $questionData->id;

        // Question Details
        $xdata["question"][] = [
            "id" => $questionId,
            "value" => $questionData->question
        ];

        if($category == "multiple_choice" || $category == "true_or_false") {

            $xdata["choices"] = array();
            $xdata["answer_key"] = array();

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
                $xdata["choices"][] = [
                    "id" => $choiceId,
                    "name" => $choice,
                    "value" => $choiceValue
                ];

                // update the answer here
                $answerKey = $validated["answer_key"];

                if($answerKey == $choice) {
                    $answerData = Answer::where('question_id', $questionId)->first();
                    $answerData->choice_id = $choiceId;
                    $answerData->answer = $choiceValue;
                    $answerData->save();
                    // Answer details

                    $answerId = $answerData->id;
                    $answerValue = $answerData->answer;
                    $xdata["answer_key"][] = [
                        "id" => $answerId,
                        "name" => $answerKey,
                        "value" => $answerValue
                    ];
                }
            }

        }

        $xretobj["data"] = $xdata;
        $xretobj["message"] = "Question updated successfully";

        return response()->json($xretobj, 200);

    }
}