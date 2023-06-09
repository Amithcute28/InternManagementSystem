<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'academic_performance',
        'program:',
        'skills',
    ];

    public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }
}
