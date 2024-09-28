<?php

if (!function_exists('hasValidRecoveryCode')) {
    function hasValidRecoveryCode($recovery_codes, $code)
    {
        // Decode JSON if necessary
        if (is_string($recovery_codes)) {
            $recovery_codes = json_decode($recovery_codes, true);
        }

        // Ensure the recovery_codes is now an array before checking
        if (!is_array($recovery_codes)) {
            return false;
        }

        return in_array($code, $recovery_codes);
    }
}

if (!function_exists('useRecoveryCode')) {
    function useRecoveryCode($recovery_codes, $code)
    {
        // Decode JSON if necessary
        if (is_string($recovery_codes)) {
            $recovery_codes = json_decode($recovery_codes, true);
        }

        // Ensure the recovery_codes is now an array before processing
        if (!is_array($recovery_codes)) {
            return $recovery_codes; // Return as is if not an array
        }

        // Remove the used recovery code
        $updatedCodes = array_filter($recovery_codes, function ($item) use ($code) {
            return $item !== $code;
        });

        // Encode back to JSON
        return json_encode(array_values($updatedCodes));
    }
}
