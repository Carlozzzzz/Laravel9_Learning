<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function store(Quiz $quiz, Request $request) {
        $validated = $this->validate($request, [
            'questionnaire.*.question' => 'required|string|min:3',
            'questionnaire.*.category' => 'required|string', // make this in enum
            'questionnaire.*.choices.*' => 'required|string|min:3',
            'questionnaire.*.answer_key'    => 'required|min:3',
        ]);

        foreach ($validated['questionnaire'] as $questionnaire) {
            // $questionnaire["category"] = "multiple_choice";

            $questionData = $quiz->questions()->createQuietly($questionnaire);

            
            foreach ($questionnaire['choices'] as $choice => $value) {

                $choiceData = $questionData->choices()->createQuietly(['choice' => $value]);

                
                if($choice == $questionnaire["answer_key"]) {
                    $xarr_param = array();
                    $xarr_param['question_id'] = $questionData->id;
                    $xarr_param['answer'] = $questionnaire["answer_key"];
                    $answerData = $choiceData->answers()->createQuietly($xarr_param);

                    echo "<pre>";
                    echo($answerData->id);
                    echo "</pre>";
                }
            }
        }
        
        dd($validated);
        
    }

   
}
