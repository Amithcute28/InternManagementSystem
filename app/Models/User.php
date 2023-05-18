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
        'password',
        'year_level',
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
        'zip_code',
        'guardian_name',
        'guardian_contact',
        'is_admin',
        'approved',
        'is_off_campus',
        'in_campus',
        'status',
        'recommended',
        'choosen_institution',
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
