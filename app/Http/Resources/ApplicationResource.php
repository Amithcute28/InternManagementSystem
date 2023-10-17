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

            'eslip'         => $this->eslip ?? null,
            'psa'           => $this->psa ?? null,
            'pros'          => $this->pros ?? null,
            'applicationF'  => $this->applicationF ?? null,
            'medical'       => $this->medical ?? null,
            'parent'        => $this->parent ?? null,
            'twobytwo'      => $this->twobytwo ?? null,
        ];
    }
}
