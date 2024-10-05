<?php

namespace App\Services;

use App\Models\SequentialIdNumber;  // Make sure to import your model if you're querying it

class IDGeneratorService
{
    public function generateIDNo()
    {
        // Get current year
        $year = date('y');

        // Retrieve the last used ID number
        $lastID = SequentialIdNumber::latest('id')->first();

        if ($lastID) {
            // Extract and increment the number part
            $lastNumber = intval(substr($lastID->id_no_used, 3)) + 1;
        } else {
            // Start from 1 if no previous ID exists
            $lastNumber = 1;
        }

        // Format the sequential number to be 12 digits
        $sequentialNumber = str_pad($lastNumber, 12, '0', STR_PAD_LEFT);

        // Combine the year and sequential number
        return $year . '-' . $sequentialNumber;
    }
}
