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
use Illuminate\Support\Facades\Storage;

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
    
    



// public function index(Request $request)
// {
//     $request->validate([
//         'term' => 'nullable|date_format:Y-m-d',
//     ]);

//     $user = Auth::user(); // Get the logged-in user

//     $dateParam = $request->input('term', '');

//     if ($dateParam) {
//         $date = Carbon::createFromFormat('Y-m-d', $dateParam)->startOfDay();
//         if ($date->isAfter(Carbon::today())) {
//             return response()->json(['Error' => 'Date cannot be in the future. Go back and choose a date before today.']);
//         }

//         $date = $date->toDateString();
//     } else {
//         $date = '';
//     }

//     $attendanceList = Attendance::select('id', 'date', 'status', 'sign_in_time', 'sign_off_time', 'notes', 'journal',
//         DB::raw('COUNT(CASE WHEN status IN (\'late\', \'on_time\') THEN 1 END) as attended_count'),
//         DB::raw('COUNT(CASE WHEN status = \'on_time\' THEN 1 END) as on_time_count'),
//         DB::raw('COUNT(CASE WHEN status = \'late\' THEN 1 END) as late_count'),
//         DB::raw('COUNT(CASE WHEN status = \'missed\' THEN 1 END) as missed_count'
//     ))
//         ->with('user') // Eager load the User model relationship
//         ->where('student_id', $user->id) // Filter by the logged-in user's ID
//         ->groupBy('id', 'date', 'status', 'sign_in_time', 'sign_off_time', 'notes', 'journal')
//         ->orderByDesc('date');

//     if ($date) {
//         $attendanceList->where('date', '=', $date);
//     }

//     $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
//         $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
//         $extension = pathinfo($value, PATHINFO_EXTENSION);
//         return in_array(strtolower($extension), $allowed_extensions);
//     })->values();

//     // Use the map method to append the public URL of each 'journal' file to the collection
//     $attendanceList->get()->map(function ($item) {
//         $item->journal_url = $item->journal ? Storage::url($item->journal) : null;
//         return $item;
//     });

//     return Inertia::render('Student/Attendance', [
//         "files" => $filtered_files,
//         "attendanceList" => $attendanceList->get(), // Use get to retrieve the results
//         "dateParam" => $date,
//         "EmployeeStats" => $user->myInfo(),
//     ]);
// }


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

    $attendanceList = Attendance::select('id','student_id','date', 'status','sign_in_time', 'sign_off_time', 'notes','journal',
        DB::raw('COUNT(CASE WHEN status IN (\'late\', \'on_time\') THEN 1 END) as attended_count'),
        DB::raw('COUNT(CASE WHEN status = \'on_time\' THEN 1 END) as on_time_count'),
        DB::raw('COUNT(CASE WHEN status = \'late\' THEN 1 END) as late_count'),
        DB::raw('COUNT(CASE WHEN status = \'missed\' THEN 1 END) as missed_count'
    ))
    ->with('user') // Eager load the User model relationship
    ->where('student_id', $user->id) // Filter by the logged-in user's ID
    ->groupBy('id','student_id','date', 'status', 'sign_in_time', 'sign_off_time', 'notes', 'journal')
    ->orderByDesc('date')
    ->get()
    ->map(function ($attendance) {
        return [
            'id' => $attendance->id,
            'student_id' => $attendance->student_id,
            'date' => $attendance->date,
            'status' => $attendance->status,
            'sign_in_time' => $attendance->sign_in_time,
            'sign_off_time' => $attendance->sign_off_time,
            'notes' => $attendance->notes,
            'attended_count' => $attendance->attended_count,
            'on_time_count' => $attendance->on_time_count,
            'late_count' => $attendance->late_count,
            'missed_count' => $attendance->missed_count,
            'journal' => $attendance->journal ? asset('storage/' . $attendance->journal) : null,
        ];
    });

    $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
        $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $allowed_extensions);
    })->values();

    return Inertia::render('Student/Attendance', [
        "files" => $filtered_files,
        "attendanceList" => $attendanceList,
        "dateParam" => $date,
        "EmployeeStats" => $user->myInfo(),
    ]);
}



// ...

// public function attendanceUpdate(Request $request, $id)
//     {
//         // Retrieve the user record from the database
//         $user = Attendance::findOrFail($id);


//         // Retrieve the associated application record
//         // $application = Attendance::where('student_id', $id)->first();

//         // Validate the incoming request data
//         $request->validate([
//             'journal' => 'nullable|file',
//         ]);

//         // Handle the evaluation form file if provided
//         if ($request->hasFile('journal')) {
//             $evalForm = $request->file('journal')->store('student', 'public');
//             $application->journal = $evalForm;
//         }

//         // Save the updated application record
//         // $application->user()->associate($user); // Associate the user with the application
//         $application->save();

//         // Redirect back to the previous page or show a success message
//         return to_route('attendance.index');
//     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::find($id);
        $student->delete();
        return to_route('admin-stes.adminStes');
    }

    public function deleteJournal(string $id)
    {
        $student = Attendance::find($id);
        $student->journal = "null";
        $student->save();
        return to_route('attendance.index');
    }



    // public function attendanceUpdate(Request $request, $id)
    // {
    //     // Retrieve the attendance record from the database
    //     $attendance = Attendance::findOrFail($id);
    
    //     // Validate the incoming request data
    //     $request->validate([
    //         'journal' => 'nullable|file',
    //     ]);
    
    //     // Get the current date
    //     $currentDate = Carbon::now()->toDateString();
    
    //     // Check if a valid file has been uploaded
    //     if ($request->hasFile('journal') && $request->file('journal')->isValid()) {
    //         // Update or create the attendance record for the user and date
    //         $attendance->updateOrCreate(
    //             ['date' => $currentDate],
    //             ['journal' => $request->file('journal')->store('student', 'public')]
    //         );
    //     }

    //     $attendance->journal = 1;
    //     $attendance->save();
    
    //     // Redirect back to the previous page or show a success message
    //     return to_route('attendance.index');
    // }
    
    public function attendanceUpdate(Request $request, $id)
{
    // Retrieve the user record from the database
    $attendance = Attendance::findOrFail($id);

    // Validate the incoming request data
    $request->validate([
        'journal' => 'nullable|file',
    ]);

    // Assuming you have a relationship between Attendance and Student models
    $student = $attendance->user; // Replace 'student' with the actual relationship name

    // if ($request->hasFile('journal')) {
    //     // Update or create the attendance record for the user and date
    //     $attendance->update(
    //         [
    //             'student_id' => $student->id, // Make sure to associate the attendance with a student
    //             'journal' => $request->file('journal')->store('student', 'public')
    //         ],
    //     );
    // }

    if ($request->hasFile('journal')) {
        $evalForm = $request->file('journal')->store('student', 'public');
        $attendance->journal = $evalForm;
    }

    // Save the updated application record
    // $application->user()->associate($user); // Associate the user with the application

    // You may want to update the 'journal' field based on your logic
    // $attendance->journal = 2;

    $attendance->save();

    // Redirect back to the previous page or show a success message
    return to_route('attendance.index');
}




// public function attendanceUpdate(Request $request, $id)
// {
//     // Retrieve the user record from the database
//     $user = User::findOrFail($id);

//     // Retrieve the associated application record or create a new one
//     $application = Attendance::where('student_id', $id)->first();
    
//     if (!$application) {
//         $application = new Attendance();
//         $application->student_id = $id;
//     }

//     // Validate the incoming request data
//     $request->validate([
//         'evalForm' => 'nullable|file',
//     ]);

//     // Handle the evaluation form file if provided
//     if ($request->hasFile('evalForm')) {
//         $evalForm = $request->file('evalForm')->store('student', 'public');
//         $application->journal = $evalForm;
//     }

//     // Associate the user with the application
//     $application->user()->associate($user);

//     // Save the updated application record
//     $application->save();

//     // Redirect back to the previous page or show a success message
//     return redirect()->route('attendance.index');
// }


// public function attendanceUpdate(Request $request, $id)
// {
//     // Retrieve the user record from the database
//     $user = User::findOrFail($id);

//     // Retrieve the associated application record
//     $application = Attendance::where('student_id', $id)->first();

//     // If the record doesn't exist, you may handle it based on your application logic
//     // if (!$application) {
//     //     return response()->json(['error' => 'Attendance record not found'], 404);
//     // }

//     // Validate the incoming request data
//     $request->validate([
//         'journal' => 'nullable|file',
//     ]);

//     // Update the 'journal' field based on the request
//     $application->journal = $request->hasFile('journal') ? $request->file('journal')->store('student', 'public') : null;

//     // Save the changes
//     $application->save();

//     // Redirect back to the previous page or show a success message
//     return redirect()->route('attendance.index');
// }








    
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

    if (!is_string($date)) {
        return $date; // Error Message
    }

    $query = Attendance::where('date', $date)
        ->join('users', 'attendances.student_id', '=', 'users.id')
        ->select([
            'attendances.student_id',
            'users.full_name',
            'users.student_school_name',
            'attendances.status',
            'attendances.sign_in_time',
            'attendances.sign_off_time',
            'attendances.notes',
            'attendances.journal',
        ])
        ->orderBy('date'); // Order by date

    // Apply search filter
    $search = request()->input('search');
    if ($search) {
        $query->where(function ($subQuery) use ($search) {
            $subQuery->whereRaw('LOWER(users.full_name) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(users.student_school_name) LIKE ?', ['%' . strtolower($search) . '%']);
        });
    }

    $perPage = request()->input('perPage') ?: 5;

    $filteredData = $query->get()->toArray();

    $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
        array_slice($filteredData, (\Illuminate\Pagination\Paginator::resolveCurrentPage() - 1) * $perPage, $perPage),
        count($filteredData),
        $perPage,
        null,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $paginateData = $paginatedData->appends(request()->query());

    return Inertia::render('Admin/Pages/AttendanceDayView', [
        'attendanceList' => $paginateData,
        'filters' => request()->only(['search', 'perPage']),
        'day' => $date,
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
