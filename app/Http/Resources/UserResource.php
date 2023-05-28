<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'student_id' => $this->student_id,
            'password'=> $this->password,
            'full_name'=> $this->full_name,
            'academic_performance'=> $this->academic_performance,
            'program'=> $this->program,
            'skills'=> $this->skills,
            'email'=> $this->email,
            'birthday'=> $this->birthday,
            'gender'=> $this->gender,
            'relationship'=> $this->relationship,
            'nationality'=> $this->nationality,
            'contact_number'=> $this->contact_number,
            'home_address'=> $this->home_address,
            'guardian_name'=> $this->guardian_name,
            'guardian_contact'=> $this->guardian_contact,
            'approved'=> $this->approved,
            'new_intern'=> $this->new_intern,
            'choosen_institution' => $this->choosen_institution
        ];
    }
}
