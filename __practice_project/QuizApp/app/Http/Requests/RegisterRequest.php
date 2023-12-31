<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'gender' => 'required|in:male,female',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'user_type' => 'required|string',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }
}
