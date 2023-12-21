<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeShift extends Model
{
    use LogsActivity;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }
    public function shift(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Shift::class, 'id', 'shift_id');
    }
}
