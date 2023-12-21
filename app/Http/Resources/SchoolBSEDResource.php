<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolBSEDResource extends JsonResource
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
        'school_name' => $this->school_name,
        'school_address' => $this->school_address,
        'school_logo' => $this->school_logo,
        'required_programs' => $this->required_programs,
        'skills' => $this->skills,  
        'slots' => $this->skills, 
       
                   
                    
                    
                    
            
        ];
        
    }
}
