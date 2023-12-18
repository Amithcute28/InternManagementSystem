<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('pdf_file', function ($attribute, $value, $parameters, $validator) {
            if (!$value instanceof \Illuminate\Http\UploadedFile) {
                return false; // If not an UploadedFile, return false
            }

            $allowedPdfTypes = ['application/pdf']; // Define allowed MIME types for PDF
            $type = $value->getMimeType();

            return in_array($type, $allowedPdfTypes);
        });

        Validator::extend('image_file', function ($attribute, $value, $parameters, $validator) {
            if (!$value instanceof \Illuminate\Http\UploadedFile) {
                return false; // If not an UploadedFile, return false
            }

            $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg']; // Define allowed MIME types for images
            $type = $value->getMimeType();

            return in_array($type, $allowedImageTypes);
        });

        Validator::replacer('pdf_file', function ($message, $attribute, $rule, $parameters) {

            $customMessages = [
                'eslip' => 'The entrance slip must be a PDF file',
                'psa' => 'The PSA Livebirth must be a PDF file',
                'pros' => 'The prospectus must be a PDF file',
                'applicationF' => 'The application form must be a PDF file',
                'medical' => 'The medical must be a PDF file',
                'parent' => "The Parent's permit must be a PDF file",
            ];

            return $customMessages[$attribute];
        });

        Validator::replacer('image_file', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The 2x2 ID  must be an image (JPEG, PNG, JPG).');
        });

        JsonResource::withoutWrapping();
    }
}
