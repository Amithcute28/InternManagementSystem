<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'full_name'     => $this->full_name ?? null,
            'program'       => $this->program ?? null,
            'profile'       => $this->profile ?? null,
            'eslip'         => asset('storage/' . $this->applicationForms?->eslip),
            'psa'           => asset('storage/' . $this->applicationForms?->psa),
            'pros'          => asset('storage/' . $this->applicationForms?->pros),
            'applicationF'  => asset('storage/' . $this->applicationForms?->applicationF),
            'medical'       => asset('storage/' . $this->applicationForms?->medical),
            'parent'        => asset('storage/' . $this->applicationForms?->parent),
            'twobytwo'      => asset('storage/' . $this->applicationForms?->twobytwo),
        ];
    }
}
