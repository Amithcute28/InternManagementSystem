<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewInternRequest extends FormRequest
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
            'skills' => 'required|string|max:255',
            'birthday' => 'required|date|date_format:Y-m-d|before:today',
            'gender' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|size:11',
            'home_address' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|size:11',
            'profile' => 'nullable|mimes:jpeg,jpg,png|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'skills.required' => 'The skills field is required.',
            'skills.string' => 'The skills field must be a string.',
            'skills.max' => 'The skills field must not exceed 255 characters.',

            'birthday.required' => 'Please enter your birthday.',
            'birthday.date' => 'The birthday must be a valid date.',
            'birthday.date_format' => 'Please enter the birthday in the format YYYY-MM-DD.',
            'birthday.before' => 'Invalid Birth Date.',

            'gender.required' => 'The gender field is required.',
            'gender.string' => 'The gender field must be a string.',
            'gender.max' => 'The gender field must not exceed 255 characters.',

            'relationship.required' => 'The relationship field is required.',
            'relationship.string' => 'The relationship field must be a string.',
            'relationship.max' => 'The relationship field must not exceed 255 characters.',

            'nationality.required' => 'The nationality field is required.',
            'nationality.string' => 'The nationality field must be a string.',
            'nationality.max' => 'The nationality field must not exceed 255 characters.',

            // ... Repeat similar pattern for other fields ...

            'contact_number.required' => 'The contact number field is required.',
            'contact_number.string' => 'The contact number must be a string.',
            'contact_number.size' => 'The contact number must be exactly 11 characters.',

            'guardian_name.required' => 'The gender field is required.',
            'guardian_name.string' => 'The gender field must be a string.',
            'guardian_name.max' => 'The gender field must not exceed 255 characters.',

            'guardian_contact.required' => 'The contact number field is required.',
            'guardian_contact.string' => 'The contact number must be a string.',
            'guardian_contact.size' => 'The contact number must be exactly 11 characters.',

            'home_address.required' => 'The home address field is required.',
            'home_address.string' => 'The home address field must be a string.',
            'home_address.max' => 'The home address field must not exceed 255 characters.',

            // ... Repeat similar pattern for other fields ...

            'profile.mimes' => 'The 2x2 ID file must be a JPG, JPEG, PNG image.',
            'profile.max' => 'The file size must not exceed 10MB.',
        ];
    }
}
