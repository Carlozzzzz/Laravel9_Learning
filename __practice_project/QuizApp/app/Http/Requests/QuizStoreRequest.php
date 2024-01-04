<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class QuizStoreRequest extends FormRequest
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
        $rules = [
            'quiz_img' => 'string',
            'title' => 'required|string|min:3',
            'instruction' => 'required|string|min:5',
            'check_points_per_item' => 'integer|max:1',
            'attempts' => 'required|integer|min:1|max:4',
            'time_limit_hr' => 'required|integer|max:24',
            'time_limit_mm' => 'required|integer|max:60',
            'time_limit_sec' => 'required|integer|max:60',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'feedback_timing' => 'required|string',
            'allow_answer_review'           => 'integer|max:1',
            'show_result_after_submission'  => 'integer|max:1',
            'randomize_choices'             => 'integer|max:1',
            'randomize_question'            => 'integer|max:1',
            'is_published'                  => 'integer|max:1',
            'is_completed'                  => 'integer|max:1',
        ];

        if ($this->input('check_points_per_item') == 1) {
            $rules['points'] = 'required|integer|min:1|max:4';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'max' => 'The :attribute must be less than :max.',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     dd($validator->errors());
    // }
}
