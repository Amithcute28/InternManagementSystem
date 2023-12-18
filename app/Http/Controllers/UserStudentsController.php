<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewInternRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\StudentsResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Globals;
use App\Services\CommonServices;
use App\Services\AttendanceServices;
use App\Services\ValidationServices;
use Carbon\Carbon;

class UserStudentsController extends Controller
{
    protected AttendanceServices $attendanceServices;
    protected ValidationServices $validationServices;
    protected CommonServices $commonServices;
    public function __construct()
    {
        $this->attendanceServices = new AttendanceServices;
        $this->validationServices = new ValidationServices;
        $this->commonServices = new CommonServices;
    }
    /**
     * Display a listing of the resource.
     */

     public function dashboardIndex()
    {
        $commonServices = new CommonServices();
        $isTodayOff = $commonServices->isTodayOff();

        $attendanceChecker = auth()->user()->attendances()->where('date', Carbon::today()->toDateString())->first();

        if (is_null($attendanceChecker)) {
            $attendanceStatus = 0;
        } else if ($attendanceChecker->sign_off_time == null) {
            $attendanceStatus = 1;
        } else {
            $attendanceStatus = 2;
        }
        
        return Inertia::render('Attendance/AttendanceDashboard', [
            "employee_stats" => auth()->user()->myInfo(),
            "attendance_status" => $attendanceStatus,
            "is_today_off" => $isTodayOff,
        ]);
    }


    public function index(): Response
{
    $user = Auth::user();
    
   

    $commonServices = new CommonServices();
        $isTodayOff = $commonServices->isTodayOff();

        $attendanceChecker = auth()->user()->attendances()->where('date', Carbon::today()->toDateString())->first();

        if (is_null($attendanceChecker)) {
            $attendanceStatus = 0;
        } else if ($attendanceChecker->sign_off_time == null) {
            $attendanceStatus = 1;
        } else {
            $attendanceStatus = 2;
        }

         if ($user->new_intern == 0) {
        return Inertia::render('Student/NewIntern', [
            'users' => UserResource::collection(User::where('id', '=', auth()->user()->id)->get()),
        ]);
    }
   
    return Inertia::render('Student/Main', [
        'users' => UserResource::collection(User::where('id', '=', $user->id)->get()),
        // 'salary' => $user->salary(),
        // 'payroll_day' => Globals::first()->payroll_day,
        // "employee_stats" => auth()->user()->myStats(),
        "attendance_status" => $attendanceStatus,
        "is_today_off" => $isTodayOff,
    ]);
}


    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Student/Main', [
            'users' => new UserResource($user),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Student/Main', [
            'users' => new UserResource($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $twobytwo = '';

        // if ($request->hasFile('eslip')) {
        //     $eslip = $request->file('eslip')->store('student', 'public');
        // }

        // ApplicationForm::create([
        //     'user_id' => $userId,
        //     'eslip' => $eslip,
        //     'psa' => $psa,
        //     'pros' => $pros,
        //     'applicationF' => $applicationF,
        //     'medical' => $medical,
        //     'parent' => $parent,
        //     'twobytwo' => $twobytwo,
        //     'approved' => 1,
        //     'is_admin' => 0,
        // ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Student/ProfileEdit', [
            'user' => new UserResource($user)
        ]);
    }

    public function updateNewIntern(NewInternRequest $request, User $user): RedirectResponse
    {

        $user = Auth::user();
        $profile = '';

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile')->store('student', 'public');
        }

        $user->update([
            'skills' => $request->skills,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'relationship' => $request->relationship,
            'nationality' => $request->nationality,
            'contact_number' => $request->contact_number,
            'home_address' => $request->home_address,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
            'new_intern' => 1,
            'profile' => $profile,


        ]);




        return to_route('user.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255|' . Rule::unique('users', 'student_id')->ignore($user),
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($user),
            'birthday' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:255',
            'student_school_name' => 'required|string|max:255',
            'student_school_code' => 'required|string|max:255',
            'student_shift' => 'required|string|max:255',


        ]);



        $user->update([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'year_level' => $request->year_level,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'relationship' => $request->relationship,
            'nationality' => $request->nationality,
            'contact_number' => $request->contact_number,
            'home_address' => $request->home_address,
            'zip_code' => $request->zip_code,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
            'student_school_name' => $request->student_school_name,
            'student_school_code' => $request->student_school_code,
            'student_shift' => $request->student_shift,
        ]);

        return to_route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return to_route('students.index');
    }
}
