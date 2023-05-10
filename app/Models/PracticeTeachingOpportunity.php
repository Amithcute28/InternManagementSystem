<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeTeachingOpportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'required_skills',
        'subject_area',
        'grades',
    ];
}
