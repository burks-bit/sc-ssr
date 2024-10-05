<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's naming conventions
    protected $table = 'members';

    // Define fillable properties to allow mass assignment
    protected $fillable = [
        'senior_citizen_id_no',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'brgy',
        'city',
        'province',
        'postal_code',
        'text_address',
        'phone_number',
        'email',
    ];

    // Define relationships if any (example)
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy', 'id'); // Adjust according to your setup
    }
}
