<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'eslip',
        'psa',
        'pros',
        'applicationF',
        'medical',
        'parent',
        'twobytwo',


    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
