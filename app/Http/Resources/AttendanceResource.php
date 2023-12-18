<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_id'         => $this->student_id ?? null,
            'full_name' => $this->user->full_name ?? null, // Assuming the relationship is named 'user'
            'date'           => $this->date ?? null,
            'status'          => $this->status ?? null,
            'sign_in_time'  => $this->sign_in_time ?? null,
            'sign_off_time'       => $this->sign_off_time ?? null,
            'notes'        => $this->notes ?? null,
            
        ];
    }
}
