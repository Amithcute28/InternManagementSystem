<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'id',
        'student_id',
        'date',
        'status',
        'sign_in_time',
        'sign_off_time',
        'notes',
        'journal',


    ];

    // public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    // {
    //     // return $this->belongsTo(User::class);
    //     // return $this->belongsTo(User::class, 'student_id', 'id');
    //     return $this->belongsTo(User::class, 'student_id'); 
    // }

//     public function user()
// {
//     return $this->belongsTo(User::class, 'student_id');
// }


// public function user(): BelongsTo
// {
//     return $this->belongsTo(User::class);
// }

public function user()
{
    return $this->belongsTo(User::class, 'student_id');
}

    public function on_time(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class)->where('status', 'on_time');
    }
}
