<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncampusResource extends JsonResource
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
            'student_id'    => $this->student_id,
            'full_name'     => $this->full_name ?? null,
            'email'         => $this->email ?? null,
            'program'       => $this->program ?? null,
            'profile'       => $this->profile ?? null,
            'eslip'         => asset('storage/' . $this->applicationForms->first()?->eslip),
            'psa'           => asset('storage/' . $this->applicationForms->first()?->psa),
            'pros'          => asset('storage/' . $this->applicationForms->first()?->pros),
            'applicationF'  => asset('storage/' . $this->applicationForms->first()?->applicationF),
            'medical'       => asset('storage/' . $this->applicationForms->first()?->medical),
            'parent'        => asset('storage/' . $this->applicationForms->first()?->parent),
            'twobytwo'      => asset('storage/' . $this->applicationForms->first()?->twobytwo),
            'eval_form'     => asset('storage/' . $this->applicationForms->first()?->eval_form),
        ];
    }
}
