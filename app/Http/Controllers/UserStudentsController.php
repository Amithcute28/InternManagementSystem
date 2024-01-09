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
use App\Models\Zipcode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            $provinces = Zipcode::select('major_area')
                ->distinct()
                ->orderBy('major_area')
                ->pluck('major_area')
                ->toArray();

            $zipcodes = Zipcode::select('zip_code')
                ->distinct()
                ->orderBy('zip_code')
                ->pluck('zip_code')
                ->toArray();

            return Inertia::render('Student/NewIntern', [
                'users' => UserResource::collection(User::where('id', '=', auth()->user()->id)->get()),
                'provinces' => $provinces,
                'zipcodes' => $zipcodes,
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


    public function getCities($province)
    {

        $cities = Zipcode::where('major_area', $province)
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->toArray();
        return Inertia::render('Student/NewIntern', [

            'cities' =>  $cities,

        ]);
    }

    public function getZipcode($province, $city)
    {
        $zipcode = Zipcode::where('major_area', $province)
            ->where('city', $city)
            ->distinct()
            ->orderBy('zip_code')
            ->pluck('zip_code')
            ->toArray();
        return Inertia::render('Student/NewIntern', [
            'zipcode' =>  $zipcode,

        ]);
    }



    public function getProvinceAndCity($zipCode)
    {
        $data = Zipcode::where('zip_code', $zipCode)->first();

        if ($data) {
            $province = $data->major_area;
            $city = $data->city;

            $provinces = Zipcode::select('major_area')
                ->distinct()
                ->orderBy('major_area')
                ->pluck('major_area')
                ->toArray();

            $cities = Zipcode::where('major_area', $province)
                ->distinct()
                ->orderBy('city')
                ->pluck('city')
                ->toArray();



            $zipcodeData = Zipcode::where('major_area', $province)
                ->where('city', $city)
                ->distinct()
                ->orderBy('zip_code')
                ->pluck('zip_code')
                ->toArray();



            return Inertia::render('Student/NewIntern', [
                'provinces' => $provinces,
                'cities' => $cities,
                'zipcode_zip' => $zipcodeData,
                'province_zip' => $province,
                'city_zip' => $city,
            ]);
        }
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

        $skillsAsString = implode(', ', $request->skills);

        $user->update([

            'skills' => $skillsAsString,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'relationship' => $request->relationship,
            'nationality' => $request->nationality,
            'contact_number' => $request->contact_number,
            'province' => $request->province,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'barangay' => $request->barangay,
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
    public function update(NewInternRequest $request, User $user): RedirectResponse
    {
       

        $profile = '';

        if ($request->hasFile('profile')) {
            // Delete the old image if it exists
            if ($user->profile) {
                Storage::delete('public/' . $user->profile);
            }

            // Store the new image and get the path
            $profilePath = $request->file('profile')->store('student', 'public');
        } else {
            // If no new image is uploaded, keep the current profile image path
            $profilePath = $user->profile;
        }



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
            'zip_code' => $request->zip_code,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
            'student_school_name' => $request->student_school_name,
            'student_school_code' => $request->student_school_code,
            'student_shift' => $request->student_shift,
            'profile' => $profilePath
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
