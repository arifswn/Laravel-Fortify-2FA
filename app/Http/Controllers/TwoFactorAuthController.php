<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Illuminate\Support\Facades\Password;

class TwoFactorAuthController extends Controller
{

    // Menampilkan halaman pengaturan kode pemulihan
    public function recoveryCodes()
    {
        $user = Auth::user();
        return view('auth.two-factor.recovery-codes', ['recoveryCodes' => $user->recoveryCodes()]);
    }

    // Menghasilkan kode pemulihan baru
    public function generateRecoveryCodes(Request $request)
    {
        $user = $request->user();

        // Get the current time
        $now = Carbon::now();

        // Check if recovery codes were generated in the last 24 hours
        if ($user->recovery_codes_generated_at && $user->recovery_codes_generated_at->diffInHours($now) < 24) {
            return redirect()->back()->with('status', 'You can only generate new recovery codes once every 24 hours.');
        }

        // Generate recovery codes
        $recoveryCodes = $user->generateRecoveryCodes();

        // Update the timestamp
        $user->recovery_codes_generated_at = $now;
        $user->save();

        return redirect()->back()->with('status', 'New recovery codes have been generated.');
    }

    public function confirm(Request $request)
    {
        $confirmed = $request->user()->confirmTwoFactorAuth($request->code);

        if (!$confirmed) {
            return back()->withErrors('The provided Two-Factor Authentication code is invalid.');
        }

        return redirect()->back()->with('status', 'Two-factor authentication has been confirmed successfully.');
    }

    public function destroy(Request $request, DisableTwoFactorAuthentication $disable)
    {
        $user = $request->user();
        $disable($user);

        // Set 'two_factor_confirmed' to false (0) after disabling 2FA
        $user->two_factor_confirmed = false;
        $user->save();

        // Return a JSON response or redirect based on the request type
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'Two-factor authentication has been disabled successfully.',
                'two_factor_confirmed' => $user->two_factor_confirmed
            ], 200);
        } else {
            return redirect()->back()->with('status', 'Two-factor authentication has been disabled successfully.');
        }
    }

    public function enable(Request $request, EnableTwoFactorAuthentication $enable)
    {
        $user = $request->user();

        // Call the action to enable 2FA for the user
        $enable($user);

        // Set 'two_factor_confirmed' to false (0) as 2FA is now enabled but not yet confirmed
        $user->two_factor_confirmed = false;
        $user->save();

        // Return a JSON response or redirect based on the request type
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'Two-factor authentication has been enabled successfully.',
                'two_factor_confirmed' => $user->two_factor_confirmed
            ], 200);
        } else {
            return redirect()->back()->with('status', 'Two-factor authentication has been enabled successfully.');
        }
    }
}
