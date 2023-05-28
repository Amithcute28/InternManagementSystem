<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Schoolbsed extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'namebsed',
        'address',
        'school_logo',
        'required_programs',
        'skills',
        'required_academic_performance',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('program');
    }
}
