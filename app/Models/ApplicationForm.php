<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'fname',
        'lname',
        'eslip',
        'psa',
        'pros',
        'applicationF',
        'medical',
        'parent',
        'twobytwo',


    ];
}
