<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Laravel\Sanctum\HasApiTokens;
use Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'recovery_codes_generated_at' => 'datetime',
    ];

    public function confirmTwoFactorAuth($code)
    {
        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($this->two_factor_secret), $code);

        if ($codeIsValid) {
            $this->two_factor_confirmed = true;
            $this->two_factor_confirmed_at = now();
            $this->save();

            return true;
        }

        return false;
    }

    public function recoveryCodes()
    {
        // Check if two_factor_secret is set to ensure 2FA is enabled
        if (!$this->two_factor_secret) {
            return [];
        }

        // If two_factor_recovery_codes is null or not set, return an empty array
        if (empty($this->two_factor_recovery_codes)) {
            return [];
        }

        // Handle the case where two_factor_recovery_codes is set but not in JSON format
        try {
            // Decode the JSON encoded recovery codes
            $decodedCodes = json_decode($this->two_factor_recovery_codes, true);

            // Return the decoded codes if it is an array, otherwise return an empty array
            return is_array($decodedCodes) ? $decodedCodes : [];
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return [];
        }
    }


    public function generateRecoveryCodes()
    {
        // Generate 8 random recovery codes, each 10 characters long
        $codes = collect(range(1, 8))->map(function () {
            return Str::random(10);
        })->toArray();

        // Check if the model instance exists and is saved
        if (!$this->exists) {
            throw new \Exception("Model instance does not exist. Cannot update recovery codes.");
        }

        // Update the 'two_factor_recovery_codes' attribute
        $this->two_factor_recovery_codes = json_encode($codes);

        // Save the model instance to persist changes
        $this->save();

        // Optional: Return a success message or handle post-save logic
        return response()->json(['message' => 'Recovery codes updated successfully.']);
    }


}
