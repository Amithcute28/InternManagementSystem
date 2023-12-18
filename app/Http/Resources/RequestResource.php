<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'employee_id'         => $this->employee_id ?? null,
            'type'           => $this->type ?? null,
            'start_date'          => $this->start_date ?? null,
            'end_date'  => $this->end_date ?? null,
            'message'       => $this->message ?? null,
            'status'        => $this->status ?? null,
            'admin_response'        => $this->admin_response ?? null,
            'is_seen'        => $this->is_seen ?? null,
            
        ];
    }
}
