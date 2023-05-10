<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    public function getRecommendations($academicPerformance)
{
    return $this->where('mentorship_rating', '>=', 4)
        ->where('hands_on_rating', '>=', 3)
        ->get();
}
}
