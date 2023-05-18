<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
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
