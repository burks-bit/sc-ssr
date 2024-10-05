<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SequentialIdNumber extends Model
{
    use HasFactory;

    protected $table = 'sequential_id_numbers';

    protected $fillable = ['id_no_used', 'status'];

    public $timestamps = true;
}
