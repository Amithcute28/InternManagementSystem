<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'school_name',
        'school_address',
        'school_logo',
    ];
}