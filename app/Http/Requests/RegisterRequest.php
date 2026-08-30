<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->name),
            'email' => strtolower(trim((string) $this->email)),
            'number' => preg_replace('/[^0-9]/', '', (string) $this->number),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[\pL\s]+$/u',
            ],

            'number' => [
                'required',
                'digits:10',
                'unique:users,number',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'max:15',
            ],

            'terms' => [
                'required',
                'accepted',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Name must contain at least 3 characters.',
            'name.max' => 'Name cannot exceed 50 characters.',
            'name.regex' => 'Name can contain only letters and spaces.',

            'number.required' => 'Please enter your mobile number.',
            'number.digits' => 'Mobile number must contain exactly 10 digits.',
            'number.unique' => 'This mobile number is already registered.',

            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',

            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must contain at least 6 characters.',
            'password.max' => 'Password cannot exceed 15 characters.',

            'terms.required' => 'Please accept the terms and conditions.',
            'terms.accepted' => 'Please accept the terms and conditions.',
        ];
    }

    public function attributes(): array
    {
        return [
            'number' => 'mobile number',
            'password_confirmation' => 'confirm password',
        ];
    }
}