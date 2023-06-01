<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'eslip' => 'nullable|mimes:pdf|max:10240', // Example for image, PDF, and document file uploads
            'psa' => 'nullable|mimes:pdf|max:10240',
            'pros' => 'nullable|mimes:pdf|max:10240',
            'applicationF' => 'nullable|mimes:pdf|max:10240',
            'medical' => 'nullable|mimes:pdf|max:10240',
            'parent' => 'nullable|mimes:pdf|max:10240',
            'twobytwo' => 'nullable|mimes:jpeg,jpg,png|max:10240',
        ];
    }

    public function messages()
    {
        return [

            'eslip.mimes' => 'The Entrance Slip file must be PDF file.',
            'eslip.max' => 'The file size must not exceed 10MB.',

            'psa.mimes' => 'The PSA LiveBirth file must be PDF file.',
            'psa.max' => 'The file size must not exceed 10MB.',

            'pros.mimes' => 'The Prospectus file must be a PDF file.',
            'pros.max' => 'The file size must not exceed 10MB.',
            'applicationF.required' => 'The Application Form field is required.',
            'applicationF.mimes' => 'The Application Form file must be PDF file.',
            'applicationF.max' => 'The file size must not exceed 10MB.',
            'medical.required' => 'The Medical Certificate field is required.',
            'medical.mimes' => 'The Medical Certificate file must be a PDF file.',
            'medical.max' => 'The file size must not exceed 10MB.',

            'parent.mimes' => "The Parent's Permit file must be a PDF file.",
            'parent.max' => 'The file size must not exceed 10MB.',

            'twobytwo.mimes' => 'The 2x2 ID file must be a JPG, JPEG, PNG image.',
            'twobytwo.max' => 'The file size must not exceed 10MB.',

        ];
    }
}
