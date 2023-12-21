<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Requests extends Model
{
    use LogsActivity;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => match ($value) {
                0 => 'Pending',
                1 => 'Approved',
                2 => 'Rejected',
            },
        );
    }
}
