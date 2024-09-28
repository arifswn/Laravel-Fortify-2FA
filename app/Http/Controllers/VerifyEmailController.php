<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Mark the user's email as verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home.index')->with('status', 'Already verified. Cannot verify again.');
        }

        $request->fulfill(); // Complete the email verification

        // Return a success response after verification
        return redirect()->route('home.index')->with('status', 'Verification successful. You can now access the application.');
    }
}
