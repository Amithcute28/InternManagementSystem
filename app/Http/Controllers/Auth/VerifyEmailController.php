<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Log out the user to prevent auto-login
            Auth::logout();

            // Redirect to the login route with a verified message
            return redirect()->route('login')->with('status', 'Your email has been verified. Please wait for the approval of Admin.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            // Log out the user to prevent auto-login
            Auth::logout();

            // Redirect to the login route with a verified message
            return redirect()->route('login')->with('status', 'Your email has been verified. Please wait for the approval of Admin.');
        }

        // If the email is already verified, just redirect to the login page
        return redirect()->route('login');
    }
}
