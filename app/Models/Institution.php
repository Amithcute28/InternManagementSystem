<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Institution extends Model
{
    use HasFactory;
    protected $fillable = [
    'name', 
    'address', 
    'requirements', 
    'academic_performance',
    'required_programs',
    'skills',
];

public function users()
{
    return $this->belongsToMany(User::class)->withPivot('program');
}
}
