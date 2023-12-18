<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Services\CommonServices;
use App\Http\Resources\AttendanceResource;
use App\Services\AttendanceServices;
use App\Services\ValidationServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;
use App\Models\Globals;

class AttendanceController extends Controller
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
    
        public function attendanceDashboard()
        {
            $user = Auth::user();
    
            return Inertia::render('Student/AttendanceDashboard', [
                "EmployeeStats" => $user->myInfo(),
            ]);
        }

    //     public function attendanceList(Request $request)
    // {
    //     $request->validate([
    //         'term' => 'nullable|date_format:Y-m-d',
    //     ]);
    //     $dateParam = $request->input('term', '');

    //     if ($dateParam) {
    //         $date = Carbon::createFromFormat('Y-m-d', $dateParam)->startOfDay();
    //         if ($date->isAfter(Carbon::today()))
    //             return response()->json(['Error' => 'Date cannot be in the future. Go back and choose a date before today.']);

    //         $date = $date->toDateString();
    //     } else {
    //         $date = '';
    //     }

    //     if ($date)
    //         $attendanceList->where('date', '=', $date);

    //         $users = User::all();

    //         $allusersAttendance = collect();
    //         // Retrieve user data from the users table

    //         foreach ($users as $user) {
    //         $userData = User::find($user->id);
            
    //         // Retrieve attendance data
    //         $studentAttendance = AttendanceResource::collection(
    //             Attendance::where('student_id', $user->id)->get() ?? []
    //         )->map(function ($attendance) use ($userData) {
    //             // Add user data to each attendance record
    //             return [
    //                 'date' => $attendance->date,
    //                 'status' => $attendance->status,
    //                 'full_name' => $userData->full_name, // Change this according to your user model's attribute
    //                 'sign_in_time' => $attendance->sign_in_time,
    //                 'sign_off_time' => $attendance->sign_off_time,
    //                 'notes' => $attendance->notes,
    //             ];
    //         });

    //         $allusersAttendance = $allusersAttendance->merge($studentAttendance);
    //     }
           
    //         $commonServices = new CommonServices();
    //         $isTodayOff = $commonServices->isTodayOff();
    
    //         $attendanceChecker = auth()->user()->attendances()->where('date', Carbon::today()->toDateString())->first();
    
    //         if (is_null($attendanceChecker)) {
    //             $attendanceStatus = 0;
    //         } else if ($attendanceChecker->sign_off_time == null) {
    //             $attendanceStatus = 1;
    //         } else {
    //             $attendanceStatus = 2;
    //         }

    //     return Inertia::render('Admin/Pages/Attendance', [
    //         // "attendanceList" => AttendanceResource::collection(Attendance::where('student_id', $user->id)->get() ?? []),
    //         "attendanceList" => $allusersAttendance,
    //         "dateParam" => $date,
    //     ]);
    // }
      
    public function attendanceList(Request $request)
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

    $attendanceList = Attendance::select('date',
        DB::raw('COUNT(CASE WHEN status IN (\'late\', \'on_time\') THEN 1 END) as attended_count'),
        DB::raw('COUNT(CASE WHEN status = \'on_time\' THEN 1 END) as on_time_count'),
        DB::raw('COUNT(CASE WHEN status = \'late\' THEN 1 END) as late_count'),
        DB::raw('COUNT(CASE WHEN status = \'missed\' THEN 1 END) as missed_count'
    ))
    ->groupBy('date')
    ->orderByDesc('date');

    if ($date) {
        $attendanceList->where('date', '=', $date);
    }

    return Inertia::render('Admin/Pages/Attendance', [
        // "attendanceList" => $attendanceList->get(), // Use get instead of paginate
        "attendanceList" => $attendanceList->paginate(config('constants.data.pagination_count')),
        "dateParam" => $date,
    ]);
}
    
    



public function index(Request $request)
{
    $request->validate([
        'term' => 'nullable|date_format:Y-m-d',
    ]);

    $user = Auth::user(); // Get the logged-in user

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

    $attendanceList = Attendance::select('date', 'status','sign_in_time', 'sign_off_time', 'notes',
        DB::raw('COUNT(CASE WHEN status IN (\'late\', \'on_time\') THEN 1 END) as attended_count'),
        DB::raw('COUNT(CASE WHEN status = \'on_time\' THEN 1 END) as on_time_count'),
        DB::raw('COUNT(CASE WHEN status = \'late\' THEN 1 END) as late_count'),
        DB::raw('COUNT(CASE WHEN status = \'missed\' THEN 1 END) as missed_count'
    ))
    ->with('user') // Eager load the User model relationship
    ->where('student_id', $user->id) // Filter by the logged-in user's ID
    ->groupBy('date', 'status', 'sign_in_time', 'sign_off_time', 'notes')
    ->orderByDesc('date');

    if ($date) {
        $attendanceList->where('date', '=', $date);
    }

    return Inertia::render('Student/Attendance', [
        "attendanceList" => $attendanceList->get(), // Use get to retrieve the results
        "dateParam" => $date,
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

        $attendanceList = Attendance::with('user:users.id,full_name')->where('date', $date)->orderBy('id')->get();
        
        // try {
        //     $attendable = !$this->commonServices->isDayOff($date);
        // } catch (\Throwable $e) {
        //     // Handle the case when $commonServices is not defined or doesn't have isDayOff method
        //     // You might want to log an error, throw an exception, or set $attendable to a default value.
        //     $attendable = false;
        // }
        $attendable = !$this->commonServices->isDayOff($date);
        
        $user = Auth::user();

            $studentAttendance = AttendanceResource::collection(Attendance::where('student_id', $user->id)->where('student_id', $user->full_name)->orderBy('id')->get() ?? []);

        return Inertia::render('Admin/Pages/AttendanceCreate', [
            "dateParam" => $request->term ?? Carbon::today()->toDateString(),
            "employees" => User::select(['id', 'full_name', 'student_id'])->orderBy('id')->get(),
            "attendances" => $attendanceList,
            "attendable" => $attendable,
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $res = $this->validationServices->validateMassAttendanceCreation($request);
        return $this->attendanceServices->createAttendance($res, $this->commonServices);
    }

    public function dayShow(string $day)
    {
        $date = $this->validationServices->validateDayAttendanceDateParameter($day);
        if (!is_string($date)) // ERROR
            return $date; // Error Message

        $attendanceList = Attendance::where('date', $date)
            ->join('users', 'attendances.student_id', '=', 'users.id')
            ->select(['attendances.student_id', 'users.full_name', 'attendances.status', 'attendances.sign_in_time', 'attendances.sign_off_time', 'attendances.notes'])
            ->orderByDesc('date')->paginate(config('constants.data.pagination_count'));

        return Inertia::render('Admin/Pages/AttendanceDayView', [
            "attendanceList" => $attendanceList,    
            "day" => $date
        ]);
    }

    public function dayDelete(Request $request)
    {
        $res = $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);
        return $this->attendanceServices->deleteDayAttendance($res);
    }

    /***
     **************** SELF-TAKING ATTENDANCE SECTION ****************
     ***/

    public function dashboardSignInAttendance(Request $request)
    {
        return $this->attendanceServices->selfSignInAttendance($request);
    }

    public function dashboardSignOffAttendance(Request $request)
    {
        return $this->attendanceServices->selfSignOffAttendance($request);
    }

}
