<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'country',
        'major_area',
        'zip_code',
        'city',
        'barangay',
    ];
}
