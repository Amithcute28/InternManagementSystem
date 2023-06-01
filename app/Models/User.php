<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\ApplicationForm;
use App\Models\Institution;
use App\Models\School;
use App\Models\Schoolbsed;
use Illuminate\Contracts\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'id',
        'student_id',
        'profile',
        'password',
        'full_name',
        'academic_performance',
        'program',
        'skills',
        'email',
        'birthday',
        'gender',
        'relationship',
        'nationality',
        'contact_number',
        'home_address',
        'guardian_name',
        'guardian_contact',
        'is_admin',
        'approved',
        'new_intern',
        'is_off_campus',
        'in_campus',
        'status',
        'choosen_institution',
        ''
    ];


    public function applicationForms()
    {
        return $this->hasMany(ApplicationForm::class);
    }

    public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }
    public function schools()
    {
        return $this->belongsToMany(School::class);
    }
    public function school_bseds()
    {
        return $this->belongsToMany(Schoolbsed::class);
    }
    public function scopeApproved(Builder $query)
    {
        $query->where('approved', 1)
        ->where('is_admin', 0)
        ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
        ->whereDoesntHave('applicationForms')
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'student_id' => $user->student_id,
                'profile' => $user->profile,
                'email' => $user->email,
                'is_off_campus' => $user->is_off_campus,
                'in_campus' => $user->in_campus,
                'full_name' => $user->full_name,
                'program' => $user->program,
                'eslip' => null, // Or any other default value for missing files
                'psa' => null,
                'pros' => null,
                'applicationF' => null,
                'medical' => null,
                'parent' => null,
                'twobytwo' => null,
                'eval_form' => null,
            ];
        });
    }

    

   
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
