<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Str;

class CodeService
{
    /**
     * Generate and save a unique code.
     *
     * @return Code
     */
    public static function generateUniqueCode($package)
    {
        // Define the length of the random code
        $length = 5; // e.g., 6-digit numeric code

        // Initialize a variable for the unique code
        $uniqueCode = self::generateAndCheckUniqueCode($length);

        // Store the unique code in the database

        $barcode = $package->update(['barcode' => $uniqueCode]);

        return $uniqueCode;
    }

    /**
     * Generate and check for a unique code.
     *
     * @param int $length
     * @return string
     */
    private static function generateAndCheckUniqueCode($length)
    {
        // Loop until a unique code is generated
        do {
            // Generate a random numeric code
            $code = self::generateRandomNumericCode($length);
        } while (self::codeExists($code));

        // Return the unique code
        return $code;
    }

    /**
     * Generate a random numeric code.
     *
     * @param int $length
     * @return string
     */
    private static function generateRandomNumericCode($length)
    {

//        $code = Str::random($length);
        // Minimum number with the given length
        $min = pow(10, $length - 1);
        // Maximum number with the given length
        $max = pow(10, $length) - 1;

        // Generate the random number within the range
        $code =  mt_rand($min, $max);
        // Generate a random number within the range
        return 't'.$code;
    }

    /**
     * Check if the generated code exists in the database.
     *
     * @param string $code
     * @return bool
     */
    private static function codeExists($code)
    {
        // Query the database to check if the code exists
        return Package::where('barcode', $code)->exists();
    }
}
