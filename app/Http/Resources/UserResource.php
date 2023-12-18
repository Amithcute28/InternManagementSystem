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
            'profile' => $this->profile,
            'password'=> $this->password,
            'full_name'=> $this->full_name,
            'academic_performance'=> $this->academic_performance,
            'program'=> $this->program,
            'school_name'=> $this->school_name,
            'school_code'=> $this->school_code,
            'ste_shift'=> $this->ste_shift,
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
            'student_school_name'=> $this->student_school_name,
            'student_school_code'=> $this->student_school_code,
            'student_shift'=> $this->student_shift,
            'approved'=> $this->approved,
            'new_intern'=> $this->new_intern,
            'choosen_institution' => $this->choosen_institution,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-y H:i:s') : null,
        ];
    }
}
