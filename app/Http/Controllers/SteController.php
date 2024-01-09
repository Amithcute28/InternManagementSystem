<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Attendance;
use App\Http\Resources\UserResource;
use App\Models\School;
use App\Http\Resources\SchoolResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Services\CommonServices;
use App\Http\Resources\AttendanceResource;
use App\Services\AttendanceServices;
use App\Services\ValidationServices;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;

class SteController extends Controller
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
    public function index(): Response
    {
       
    
        return Inertia::render('STE/steDashboard');
           
    }

    public function adminStes()
    {
        // in-campus logic goes herea

        $qualifiedUsers = User::where('approved', 1)->where('is_ste', 1)
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo', 'created_at');
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'id' => $user->id,
                    'student_id' => $user->student_id,
                    'email' => $user->email,
                    'profile' => $user->profile,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'school_name' => $user->school_name,
                    'school_code' => $user->school_code,
                    'ste_shift' => $user->ste_shift,
                    'contact_number' => $user->contact_number,
                    'in_campus' => $user->in_campus,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/student/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                    'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
                ];
            });

        $perPage = request()->input('perPage') ?: 5;
        $filteredData = $qualifiedUsers->when(request()->input('search'), function ($collection, $search) {
            return $collection->filter(function ($item) use ($search) {
                return stripos($item['student_id'], $search) !== false || stripos($item['full_name'], $search) !== false;
            });
        });

        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredData->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), $perPage),
            $filteredData->count(),
            $perPage,
            null,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $paginateData = $paginatedData->appends(request()->query());

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $interns = User::where('approved', 1)->where('is_ste', 1)->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/Pages/AdminStes', [
            'files' => $filtered_files,
            'offCampus' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,
        ]);
    }

    
    public function interns()
    {
        // in-campus logic goes herea
        $userSchoolCode = auth()->user()->school_code;
        $userShift = auth()->user()->ste_shift;

        $qualifiedUsers = User::where('approved', 1)->where('is_admin', 0)
            ->where('new_intern', 1)
            ->where('in_campus', 1)
            ->where('is_off_campus', 0)
            ->where('student_school_code', $userSchoolCode) // Compare student_school_code with the school_code of the logged-in user
            ->where('student_shift', $userShift)
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo', 'created_at');
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'id' => $user->id,
                    'student_id' => $user->student_id,
                    'email' => $user->email,
                    'profile' => $user->profile,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'school_name' => $user->school_name,
                    'school_code' => $user->school_code,
                    'ste_shift' => $user->ste_shift,
                    'contact_number' => $user->contact_number,
                    'in_campus' => $user->in_campus,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/student/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                    'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
                ];
            });

        $perPage = request()->input('perPage') ?: 5;
        $filteredData = $qualifiedUsers->when(request()->input('search'), function ($collection, $search) {
            return $collection->filter(function ($item) use ($search) {
                return stripos($item['student_id'], $search) !== false || stripos($item['full_name'], $search) !== false;
            });
        });

        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredData->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), $perPage),
            $filteredData->count(),
            $perPage,
            null,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $paginateData = $paginatedData->appends(request()->query());

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $interns = User::where('approved', 1)->where('is_admin', 0)
        ->where('new_intern', 1)
        ->where('in_campus', 0)
        ->where('is_off_campus', 0)
        ->where('student_school_code', $userSchoolCode) // Compare student_school_code with the school_code of the logged-in user
        ->where('student_shift', $userShift)->get();
        $totalInterns = $interns->count();

        return Inertia::render('STE/interns', [
            'files' => $filtered_files,
            'offCampus' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,    
        ]);
    }

    public function attendanceSte(Request $request)
{
    $request->validate([
        'term' => 'nullable|date_format:Y-m-d',
    ]);

    $dateParam = $request->input('term', '');

    if ($dateParam) {
        $date = Carbon::createFromFormat('Y-m-d', $dateParam)->startOfDay();
        if ($date->isAfter(Carbon::today())) {
            return response()->json(['Error' => 'Date cannot be in the future. Go back and choose a date before today.']);
        }

        $date = $date->toDateString();
    } else {
        $date = '';
    }

    $userSchoolCode = auth()->user()->school_code;
    $userShift = auth()->user()->ste_shift;

    $attendanceList = Attendance::join('users', 'attendances.student_id', '=', 'users.id')
        ->where('users.student_school_code', '=', $userSchoolCode)
        ->where('users.student_shift', '=', $userShift)
        ->where('in_campus', 0)
        ->where('is_off_campus', 0)
        ->where('applications', 1)
        ->select('attendances.date',
            DB::raw('COUNT(CASE WHEN attendances.status IN (\'late\', \'on_time\') THEN 1 END) as attended_count'),
            DB::raw('COUNT(CASE WHEN attendances.status = \'on_time\' THEN 1 END) as on_time_count'),
            DB::raw('COUNT(CASE WHEN attendances.status = \'late\' THEN 1 END) as late_count'),
            DB::raw('COUNT(CASE WHEN attendances.status = \'missed\' THEN 1 END) as missed_count'
        ))
        ->groupBy('attendances.date')
        ->orderByDesc('attendances.date');

    if ($date) {
        $attendanceList->where('attendances.date', '=', $date);
    }

    return Inertia::render('STE/attendanceSte', [
        "attendanceList" => $attendanceList->paginate(config('constants.data.pagination_count')),
        "dateParam" => $date,
    ]);
}


public function dayShow(string $day)
{
    $date = $this->validationServices->validateDayAttendanceDateParameter($day);
    if (!is_string($date)) // ERROR
        return $date; // Error Message

        $userSchoolCode = auth()->user()->school_code;
        $userShift = auth()->user()->ste_shift;

        $attendanceList = Attendance::where('date', $date)
        ->join('users', 'attendances.student_id', '=', 'users.id')
        ->where('users.student_school_code', '=', $userSchoolCode)
        ->where('users.student_shift', '=', $userShift)
        ->select(['attendances.student_id', 'users.full_name', 'attendances.status', 'attendances.sign_in_time', 'attendances.sign_off_time', 'attendances.notes'])
        ->orderByDesc('date')->paginate(config('constants.data.pagination_count'));

    return Inertia::render('STE/AttendanceDayViewSte', [
        "attendanceList" => $attendanceList,    
        "day" => $date
    ]);
}
    /**
     * Show the form for creating a new resource.
     */
   public function create(Request $request)
    {
        
        if ($request->term) {
            $request->validate([
                'term' => 'required|date_format:Y-m-d',
            ]);
            $date = Carbon::createFromFormat('Y-m-d', urldecode($request->term))->startOfDay();
            if ($date->isAfter(Carbon::today())) {
                return response()->json(['message' => 'Date cannot be in the future. Go back and choose a date before today.']);
            }
            $date = $date->toDateString();
        } else {
            $date = Carbon::today()->toDateString();
        }

        $userSchoolCode = auth()->user()->school_code;
        $userShift = auth()->user()->ste_shift;

        $attendanceList = Attendance::where('date', $date)
        ->join('users', 'attendances.student_id', '=', 'users.id')
        ->where('users.student_school_code', '=', $userSchoolCode)
        ->where('users.student_shift', '=', $userShift)
        ->select(['attendances.student_id', 'users.full_name', 'attendances.status', 'attendances.sign_in_time', 'attendances.sign_off_time', 'attendances.notes'])
        ->orderByDesc('date');

                
        
        $attendable = !$this->commonServices->isDayOff($date);
        
        
        return Inertia::render('STE/AttendanceCreateSte', [
            "dateParam" => $request->term ?? Carbon::today()->toDateString(),
            "employees" => User::select(['id', 'full_name', 'student_id'])
            ->where('users.student_school_code', '=', $userSchoolCode)
        ->where('users.student_shift', '=', $userShift)
        ->orderBy('id')->get(),
            "attendances" => $attendanceList->get(),
            "attendable" => $attendable,
        ]); 
    }

    public function storeSte(Request $request)
    {
        $res = $this->validationServices->validateMassAttendanceCreation($request);
        return $this->attendanceServices->createAttendanceSte($res, $this->commonServices);
    }

    public function dayDelete(Request $request)
    {
        $res = $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);
        return $this->attendanceServices->deleteDayAttendanceSte($res);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
        'student_id' => 'required|string|max:255',
        'ste_shift' => 'required|string|max:255',
        'school_name' => 'required|string|max:255',
        'school_code' => 'required|string|max:255',
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'contact_number' => 'required|string|max:255',
        'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()],
        ]);

        $user = User::create([
            'student_id' => $request->student_id,
            'ste_shift' => $request->ste_shift,
            'school_name' => $request->school_name,
            'school_code' => $request->school_code, // Encode the program array to JSON
            'full_name' => $request->full_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'is_ste' => 1,
            'approved' => 1,
            


        ])->assignRole('user');

        return to_route('admin-stes.adminStes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function proceed(Request $request, string $id)
    {
        //
        $student = User::find($id);

        $student->off_campus = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('stes-interns.interns');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Retrieve the user record from the database
        $user = User::findOrFail($id);


        // Retrieve the associated application record
        $application = ApplicationForm::where('user_id', $id)->first();

        // Validate the incoming request data
        $request->validate([
            'evalForm' => 'nullable|file',
        ]);

        // Handle the evaluation form file if provided
        if ($request->hasFile('evalForm')) {
            $evalForm = $request->file('evalForm')->store('student', 'public');
            $application->eval_form = $evalForm;
        }

        // Save the updated application record
        $application->user()->associate($user); // Associate the user with the application
        $application->save();

        // Redirect back to the previous page or show a success message
        return to_route('stes-interns.interns');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
