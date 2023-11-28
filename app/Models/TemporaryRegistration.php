<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'program',
        'full_name',
        'email',
        'password',
        'token',
        // Add other fields as necessary
    ];
}
