<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|string|min:7',
            'program' => 'required|string|in:BEED,BECEd,BSNEd,BPEd,BSED English,BSED Filipino,BSED Mathematics,BSED Science,BSED Social Studies',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()],
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'The student ID field is required.',
            'student_id.string' => 'The student ID must be a string.',
            'student_id.min' => 'The student ID must be at least 7 characters.',

            'program.required' => 'The program field is required.',
            'program.string' => 'The program must be a string.',
            'program.in' => 'Please choose a valid program.',

            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.max' => 'The full name must not exceed 255 characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'The email has already been taken.',

            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least :min characters.',
            'password.numbers' => 'The password must include at least one number.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.'

        ];
    }
}
