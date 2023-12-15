<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $category = $this->input('category');
        $questionOption = $this->input('question_option');

        $commonRules = [
            'question' => 'required|string|min:3',
            'category' => 'required|string',
            'choice.*' => 'required|string|min:3',
           
        ];

        if($questionOption == "update"){
            return array_merge($commonRules, [
                'question_id' => 'required',
                'answer_key' => 'required',
                'choiceId.*' => 'required',
            ]);
        }

        if ($category == "multiple_choice") {
            return array_merge($commonRules, [
                'answer_key' => 'required',
            ]);
        } elseif ($category == "true_or_false") {
            return array_merge($commonRules, [
                'answer_key' => 'required',
            ]);
        } elseif ($category == "checklist") {
            return array_merge($commonRules, [
                'answer_key.*' => 'required',
            ]);
        } elseif ($category == "enumeration") {
            return array_merge($commonRules, [
                'choice.*' => 'required',
            ]);
        }
    }

    /**
     * Get custom error messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'question.required' => 'The question field is required.',
            'category.required' => 'The category field is required.',
            'choice.*.required' => 'The choice field is required.',
            'choice.*.min' => 'The choice field must be at least 3 characters.',
            'answer_key.*.required' => 'The answer key is required.',
        ];
    }
}
