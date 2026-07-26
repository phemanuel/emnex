<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'company_code' => ['required','string'],

            'username' => ['required','string'],

            'password' => ['required','string'],

            'remember' => ['nullable','boolean'],

        ];
    }

    public function messages(): array
    {
        return [

            'company_code.required' => 'Company code is required.',

            'username.required' => 'Username is required.',

            'password.required' => 'Password is required.',

        ];
    }
}