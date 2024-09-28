<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecoveryTwoFactorAuthController extends Controller
{
    public function showForgot()
    {
        // Render the recovery code view
        return view('auth.two-factor.forgot-recovery-codes');
    }

    public function processForgot(Request $request)
    {
        // Validate the recovery code input
        $request->validate([
            'recovery_code' => ['required', 'string'],
        ]);

        // Retrieve the user ID from the session
        $userId = $request->session()->get('login')['id'] ?? null;
        $user = $userId ? User::find($userId) : null;
        $code = $request->input('recovery_code');

        // Check if user exists
        if (!$user) {
            return redirect()->back()->withErrors([
                'error' => 'User not authenticated or not found.'
            ]);
        }

        // Prepare user data as rows
        $userRow = [];
        foreach ($user->toArray() as $key => $value) {
            $userRow[$key] = is_array($value) ? json_encode($value) : $value;
        }

        // Check if the user has recovery codes
        $recoveryCodes = $userRow['two_factor_recovery_codes'];

        // Ensure recovery_codes is loaded
        // Check if the recovery code is valid
        if (!hasValidRecoveryCode($recoveryCodes, $code)) {
            return redirect()->back()->withErrors([
                'recovery_code' => ['The provided recovery code is invalid.'],
            ]);
        }

        $afterUsingRecoveryCode = useRecoveryCode($recoveryCodes, $code);
        $user->two_factor_recovery_codes = $afterUsingRecoveryCode;
        $user->save();

        // Log in the user
        Auth::login($user);

        // Redirect to home or any intended route with a success message
        return redirect()->intended('/home')->with('status', 'Recovery code verified successfully.');
    }
}
