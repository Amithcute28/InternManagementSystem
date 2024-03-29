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
            'eslip' => 'required|mimes:pdf|max:10240', // Example for image, PDF, and document file uploads
            'psa' => 'required|mimes:pdf|max:10240',
            'pros' => 'required|mimes:pdf|max:10240',
            'applicationF' => 'required|mimes:pdf|max:10240',
            'medical' => 'required|mimes:pdf|max:10240',
            'parent' => 'required|mimes:pdf|max:10240',
            'twobytwo' => 'required|mimes:jpeg,jpg,png|max:10240',
        ];
    }

    public function messages()
    {
        return [

            'eslip.required' => 'The Entrance Slip field is required.',
            'eslip.mimes' => 'The Entrance Slip file must be PDF file.',
            'eslip.max' => 'The file size must not exceed 10MB.',

            'psa.required' => 'The PSA field is required.',
            'psa.mimes' => 'The PSA LiveBirth file must be PDF file.',
            'psa.max' => 'The file size must not exceed 10MB.',

            'pros.required' => 'The Prospectus field is required.',
            'pros.mimes' => 'The Prospectus file must be a PDF file.',
            'pros.max' => 'The file size must not exceed 10MB.',

            'applicationF.required' => 'The Application Form field is required.',
            'applicationF.mimes' => 'The Application Form file must be PDF file.',
            'applicationF.max' => 'The file size must not exceed 10MB.',

            'medical.required' => 'The Medical Certificate field is required.',
            'medical.mimes' => 'The Medical Certificate file must be a PDF file.',
            'medical.max' => 'The file size must not exceed 10MB.',

            'parent.required' => "The Parent's field is required.",
            'parent.mimes' => "The Parent's Permit file must be a PDF file.",
            'parent.max' => 'The file size must not exceed 10MB.',

            'twobytwo.required' => 'The 2x2 ID is required.',
            'twobytwo.mimes' => 'The 2x2 ID file must be a JPG, JPEG, PNG image.',
            'twobytwo.max' => 'The file size must not exceed 10MB.',

        ];
    }
}
