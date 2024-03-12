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
use App\Services\CommonServices;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected CommonServices $commonServices;
    public function __construct()
    {
        $this->commonServices = new CommonServices;
    }
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
        'school_name',
        'school_code',
        'ste_shift',
        'skills',
        'email',
        'birthday',
        'gender',
        'relationship',
        'province',
        'city',
        'zip_code',
        'barangay',
        'nationality',
        'contact_number',
        'home_address',
        'guardian_name',
        'guardian_contact',
        'student_school_name',
        'student_school_code',
        'student_shift',
        'is_ste',
        'is_admin',
        'approved',
        'new_intern',
        'is_off_campus',
        'in_campus',
        'status',
        'choosen_institution',
        ''
    ];

   

    public function myInfo()
    {
        // Get Data for current month
        $now = CarbonImmutable::now();
        $curDay = $now->day;
        $curMonth = $now->month;
        $curYear = $now->year;
        $monthEnd = $now->endOfMonth()->format('j');
        $globalSettings = Globals::first();
        $commonServices = new \App\Services\CommonServices();
        $monthDates = [$curYear, $curMonth, 1, $curYear, $curMonth, $monthEnd];
    
        // Calculations for the entire month
        $holidaysCount = $commonServices->countHolidays($monthDates);
        $weekendsCount = $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on, $monthDates);
        $workingDays = $monthEnd - $holidaysCount - $weekendsCount;
    
        // Calculations from the start of the month until today.
        $holidaysCountSoFar = $commonServices->countHolidays([$curYear, $curMonth, 1, $curYear, $curMonth, $curDay]);
        $workingDaysSoFar = $curDay - 1 - $holidaysCountSoFar - // -1 to exclude today
            $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on, [$curYear, $curMonth, 1, $curYear, $curMonth, $curDay]);
    
        // Calculations for the entire year until today
        $workDaysSoFarThisYear = $now->startOfYear()->diffInDays($now) - $commonServices->countHolidays([$curYear, 1, 1, $curYear, $curMonth, $curDay]) -
            $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on, [$curYear, 1, 1, $curYear, $curMonth, $curDay]);
    
        // Calculating attendance stats for the month
        $attended = $this->getAttended();
        $absented = $this->getAbsented();
    
        $monthAttendance = (clone $attended)->whereYear('date', $curYear)->whereMonth('date', $curMonth)->get();
    
        if (Carbon::parse($this->hired_on)->year < $curYear) {
            $totalAttendanceSoFar = (clone $attended)->whereYear('date', $curYear)
                ->whereDate('date', '<=', $now)->count();
    
            $totalAbsentedSoFar = (clone $absented)->whereYear('date', $curYear)
                ->whereDate('date', '<=', $now)->count();
        } else {
            $totalAttendanceSoFar = (clone $attended)->whereDate('date', '<=', $now)->count();
            $totalAbsentedSoFar = (clone $absented)->whereDate('date', '<=', $now)->count();
        }
    
        $actualHours = $monthAttendance->sum(function ($attendance) {
            $signInTime = Carbon::parse($attendance->sign_in_time);
            $signOffTime = Carbon::parse($attendance->sign_off_time);
            return $signInTime->diffInMinutes($signOffTime) / 60;
        });
    
        $shiftHours = $this->activeShiftPeriod();
        $fixedTotalHours = 144;
        $expectedHours = min($workingDays * $shiftHours, $fixedTotalHours);
        $expectedHoursSoFar = min($workingDaysSoFar * $shiftHours, $fixedTotalHours);
    
        return [
            "attendableThisMonth" => $workingDays,
            "holidaysThisMonth" => $holidaysCount,
            "weekendsThisMonth" => $weekendsCount,
            "attendedThisMonth" => $monthAttendance->count(),
            "absentedThisMonth" => $this->getAbsented()->whereMonth('date', $curMonth)->count(),
    
            "totalAttendanceThisYear" => $totalAttendanceSoFar,
            "totalAbsenceThisYear" => $workDaysSoFarThisYear - $totalAttendanceSoFar,
    
            "totalAttendanceSoFar" => $totalAttendanceSoFar,
            "totalAbsenceSoFar" => $totalAbsentedSoFar,
    
            "expectedHoursThisMonth" => $expectedHours,
            "actualHoursThisMonth" => $actualHours,
            "hoursDifference" => $actualHours - $expectedHours,
            "hoursDifferenceSoFar" => $actualHours - $expectedHoursSoFar,
        ];
    }

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
            ->whereDoesntHave('applicationForms');
    }

    public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    // public function attendances()
    // {
    //     return $this->hasMany(Attendance::class);
    // }

    public function getAttended(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // exclude absented ones
        return $this->attendances()->where('status', '!=', 'missed');
    }
    public function getAttendedInYear($year): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // exclude absented ones
        return $this->attendances()->where('status', '!=', 'missed')->whereYear('date', $year);
    }
    public function getAbsentedInYear($year): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // get absented ones
        return $this->attendances()->where('status', '=', 'missed')->whereYear('date', $year);
    }
    public function getAbsented(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // get absented ones
        return $this->attendances()->where('status', '=', 'missed');
    }

    

    public function getYearStats($globalSettings = null){
        $globalSettings ??= Globals::first();
        $commonServices = new \App\Services\CommonServices();
        $thisYearData = $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on);
        $holidaysThisYear = $commonServices->countHolidays($this->hired_on);
        return [
            "workingDaysThisYear" => $thisYearData['total_year_days'],
            "WeekendOffDaysThisYear" => $thisYearData['offDays'],
            "weekendOffDays" => json_decode($globalSettings->weekend_off_days), // Friday, Saturday.. etc
            "HolidaysThisYear" => $holidaysThisYear,
            "absence_limit" => $globalSettings->absence_limit,
        ];
    }
    public function shifts()
    {
        return $this->hasManyThrough(Shift::class, EmployeeShift::class, 'employee_id', 'id', 'id', 'shift_id');
    }

    public function employeeShifts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EmployeeShift::class, 'employee_id');
    }

    public function activeShift()
    {
        return $this->employeeShifts()
            ->with('shift')
            ->whereNull('end_date')
            ->first()->shift;
    }   
    public function activeShiftPeriod()
    {
        return $this->activeShift()?->shiftPeriod();
    }

    public function salaries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EmployeeSalary::class);
    }

    public function salary()
    {
        $salary = $this->salaries()->where('end_date', null)->first();
        return [$salary->currency, $salary->salary, $salary->start_date];
    }
    public function myStats()
    {
        // Get Data for current month
        $now = CarbonImmutable::now();
        $curDay = $now->day;
        $curMonth = $now->month;
        $curYear = $now->year;
        $monthEnd = $now->endOfMonth()->format('j');
        $globalSettings = Globals::first();
        $commonServices = new \App\Services\CommonServices();
        $monthDates = [$curYear, $curMonth, 1, $curYear, $curMonth, $monthEnd];

        // Calculations for the entire month
        $holidaysCount = $commonServices->countHolidays($this->user->hired_on, $monthDates);
        $weekendsCount = $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on, $monthDates);
        $workingDays = $monthEnd - $holidaysCount - $weekendsCount;

        // Calculations from the start of the month until today.
        $holidaysCountSoFar = $commonServices->countHolidays($this->hired_on, [$curYear, $curMonth, 1, $curYear, $curMonth, $curDay]);
        $workingDaysSoFar = $curDay - 1 -$holidaysCountSoFar - // -1 to exclude today
            $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on, [$curYear, $curMonth, 1, $curYear, $curMonth, $curDay]);

        // Calculations for the entire year until today
        $workDaysSoFarThisYear = $now->startOfYear()->diffInDays($now) - $commonServices->countHolidays($this->hired_on, [$curYear, 1, 1, $curYear, $curMonth, $curDay]) -
            $commonServices->calcOffDays(json_decode($globalSettings->weekend_off_days), $this->hired_on, [$curYear, 1, 1, $curYear, $curMonth, $curDay]);

        // Calculating attendance stats for the month
        // $totalAttendanceSoFar attendance from the start of the year (or hire date if they weren't hired this year) until today.

        $attended = $this->getAttended();
        $absented = $this->getAbsented();

        $monthAttendance = (clone $attended)->whereYear('date', $curYear)->whereMonth('date', $curMonth)->get();

        if (Carbon::parse($this->hired_on)->year < $curYear) {
            $totalAttendanceSoFar = (clone $attended)->whereYear('date', $curYear)
                ->whereDate('date', '<=', $now)->count();

            $totalAbsentedSoFar = (clone $absented)->whereYear('date', $curYear)
                    ->whereDate('date', '<=', $now)->count();
        } else {
            $totalAttendanceSoFar = (clone $attended)->whereDate('date', '<=', $now)->count();
            $totalAbsentedSoFar = (clone $absented)->whereDate('date', '<=', $now)->count();
        }
        $actualHours =
            $monthAttendance->sum(function ($attendance) {
                $signInTime = Carbon::parse($attendance->sign_in_time);
                $signOffTime = Carbon::parse($attendance->sign_off_time);
                return $signInTime->diffInMinutes($signOffTime) / 60;
            });


        $shiftHours = $this->activeShiftPeriod();
        $expectedHours = $workingDays * $shiftHours;
        $expectedHoursSoFar = $workingDaysSoFar * $shiftHours;

        return [
            "YearStats" => $this->getYearStats($globalSettings),

            "attendableThisMonth" => $workingDays,
            "holidaysThisMonth" => $holidaysCount,
            "weekendsThisMonth" => $weekendsCount,
            "attendedThisMonth" => $monthAttendance->count(),
            "absentedThisMonth" => $this->getAbsented()->whereMonth('date', $curMonth)->count(),

            "totalAttendanceThisYear" => $totalAttendanceSoFar,
            "totalAbsenceThisYear" => $workDaysSoFarThisYear - $totalAttendanceSoFar,

            "totalAttendanceSoFar" => $totalAttendanceSoFar,
            "totalAbsenceSoFar" => $totalAbsentedSoFar,

            "expectedHoursThisMonth" => $expectedHours,
            "actualHoursThisMonth" => $actualHours,
            "hoursDifference" => $actualHours - $expectedHours,
            "hoursDifferenceSoFar" => $actualHours - $expectedHoursSoFar,
        ];
    }

    public function monthHours($year, $month): array
{
    $monthEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('j');
    $commonServices = new \App\Services\CommonServices();
    $monthDates = [$year, $month, 1, $year, $month, $monthEnd];

    // Calculations for the entire month
    $holidaysCount = $commonServices->countHolidays($this->hired_on, $monthDates);
    $workingDays = $monthEnd - $holidaysCount -
        $commonServices->calcOffDays(json_decode(Globals::first()->weekend_off_days), $this->hired_on, $monthDates);

    $attended = $this->getAttended();

    $monthAttendance = (clone $attended)->whereYear('date', $year)->whereMonth('date', $month)->get();

    $shiftHours = $this->activeShiftPeriod();
    $expectedHours = $workingDays * $shiftHours;

    // Ensure the total hours are capped at the fixed value (144)
    $fixedTotalHours = 144;
    $expectedHours = min($expectedHours, $fixedTotalHours);

    $actualHours = $monthAttendance->sum(function ($attendance) {
        $signInTime = Carbon::parse($attendance->sign_in_time);
        $signOffTime = Carbon::parse($attendance->sign_off_time);
        return $signInTime->diffInMinutes($signOffTime) / 60;
    });

    // Ensure actual hours do not exceed the fixed total hours
    $actualHours = min($actualHours, $fixedTotalHours);

    return [
        "expectedHours" => $expectedHours,
        "actualHours" => $actualHours,
        "hoursDifference" => $actualHours - $expectedHours,
    ];
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
        // 'program' => 'array',
    ];
}
