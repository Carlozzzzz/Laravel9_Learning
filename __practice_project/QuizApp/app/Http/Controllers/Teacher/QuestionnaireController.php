<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionnaireController extends Controller
{
    public function store(Quiz $quiz, QuestionnaireRequest $request)
    {
        $validated = $request->validated();

        $category = $validated['category'];

        $questionData = $quiz->questions()->createQuietly($validated);

        if($category == "multiple_choice") {
            
            foreach ($validated['choice'] as $choice => $value) {
                $choiceData = $questionData->choices()->createQuietly(['choice' => $value]);

                if ($choice == $questionData["answer_key"]) {
                    $xarr_param = [
                        'question_id' => $questionData->id,
                        'answer' => $validated["answer_key"],
                    ];
                    $choiceData->answers()->createQuietly($xarr_param);
                }
            }
        } else if($category == "true_or_false") {

            $xarr_param = [
                'question_id' => $questionData->id,
                'answer' => $validated["answer_key"],
            ];
    
            $questionData->answers()->createQuietly($xarr_param);
        } else if($category == "checklist" || $category == "enumeration") {
            foreach ($validated['choice'] as $choice => $value) {
                $choiceData = $questionData->choices()->createQuietly(['choice' => $value]);
                
                if($category == "checklist") {
                    if (isset($validated["answer_key"]) && is_array($validated["answer_key"])) {
                        if (in_array($choice, $validated["answer_key"])) {
                            $xarr_param = [
                                'question_id' => $questionData->id,
                                'choice_id' => $choiceData->id,
                                'answer' => $choice,
                            ];
                            $choiceData->answers()->createQuietly($xarr_param);
                        }
                    }
                }
            }
        }
        return response()->json(['message' => 'Question created successfully'], 200);
    }
}