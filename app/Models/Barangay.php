<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id'); // Adjust according to your setup
    }
}
