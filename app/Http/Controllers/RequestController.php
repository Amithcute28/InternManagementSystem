<?php

namespace App\Http\Controllers;

use App\Services\RequestServices;
use App\Services\ValidationServices;
use App\Models\User;
use App\Models\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RequestResource;
use Illuminate\Http\Request;
use Inertia\Inertia;


// Using \App\Models\Request instead of Request because Request is a class in Illuminate\Http\Request
class RequestController extends Controller
{
    protected RequestServices $requestServices;
    protected ValidationServices $validationServices;
    public function __construct()
    {
        $this->requestServices = new RequestServices;
        $this->validationServices = new ValidationServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function adminRequestsindex()
    {
        // Retrieve all users
        $users = User::all();
    
        // Retrieve attendance data for all users
        $allUsersAttendance = collect();
    
        foreach ($users as $user) {
            // Retrieve user data from the users table
            $userData = User::find($user->id);
    
            // Retrieve attendance data
            $userAttendance = RequestResource::collection(
                Requests::where('employee_id', $user->id)->get() ?? []
            )->map(function ($attendance) use ($userData) {
                // Add user data to each attendance record
                return [
                    'id' => $attendance->id,
                    'full_name' => $userData->full_name,
                    'employee_id' => $attendance->employee_id,
                    'type' => $attendance->type,
                    'start_date' => $attendance->start_date,
                    'end_date' => $attendance->end_date,
                    'message' => $attendance->message,
                    'status' => $attendance->status,
                    'admin_response' => $attendance->admin_response,
                    'is_seen' => $attendance->notes,
                ];
            });
    
            // Merge user attendance data into the overall collection
            $allUsersAttendance = $allUsersAttendance->merge($userAttendance);
        }
    
        return Inertia::render('Admin/Pages/Requests', [
            'requests' => $allUsersAttendance,
        ]);
    }


    public function index()
    {
            $user = Auth::user();

            // Retrieve user data from the users table
            $userData = User::find($user->id);
            
            // Retrieve attendance data
            $studentAttendance = RequestResource::collection(
                Requests::where('employee_id', $user->id)->get() ?? []
            )->map(function ($attendance) use ($userData) {
                // Add user data to each attendance record
                return [
                    'id' => $attendance->id,
                    'full_name' => $userData->full_name,
                    'employee_id' => $attendance->employee_id, // Change this according to your user model's attribute
                    'type' => $attendance->type,
                    'start_date' => $attendance->start_date,
                    'end_date' => $attendance->end_date,
                    'message' => $attendance->message,
                    'status' => $attendance->status,
                    'admin_response' => $attendance->admin_response,
                    'is_seen' => $attendance->notes,
                ];
            });

        return Inertia::render('Student/Requests', [
            'requests' => $studentAttendance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Student/RequestCreate', [
            'types' => ['complaint', 'leave', 'other'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req = $this->validationServices->validateRequestCreationDetails($request);
        return $this->requestServices->createRequest($req, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = \App\Models\Requests::with('user')->findOrFail($id);
    
        // Retrieve user data from the users table
        $userData = User::find($request->employee_id);
    
        // Mark the request as seen by the employee if it was approved or rejected.
        // This will be used to display the number of unseen requests in the sidebar of the user dashboard.
        if (auth()->user()->id == $request->employee_id && $request->status != 'Pending') {
            $request->update(['is_seen' => true]);
        }
    
        return Inertia::render('Admin/Pages/RequestView', [
            'request' => [
                'id' => $request->id,
                'full_name' => $userData->full_name,
                'employee_id' => $request->employee_id, // Change this according to your user model's attribute
                'type' => $request->type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'message' => $request->message,
                'status' => $request->status,
                'admin_response' => $request->admin_response,
                'is_seen' => $request->is_seen,
                'created_at' => $request->created_at,
            ],
        ]);
    }

    public function showStudent(string $id)
    {
        $request = \App\Models\Requests::with('user')->findOrFail($id);
    
        // Retrieve user data from the users table
        $userData = User::find($request->employee_id);
    
        // Mark the request as seen by the employee if it was approved or rejected.
        // This will be used to display the number of unseen requests in the sidebar of the user dashboard.
        if (auth()->user()->id == $request->employee_id && $request->status != 'Pending') {
            $request->update(['is_seen' => true]);
        }
    
        return Inertia::render('Student/RequestView', [
            'request' => [
                'id' => $request->id,
                'full_name' => $userData->full_name,
                'employee_id' => $request->employee_id, // Change this according to your user model's attribute
                'type' => $request->type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'message' => $request->message,
                'status' => $request->status,
                'admin_response' => $request->admin_response,
                'is_seen' => $request->is_seen,
                'created_at' => $request->created_at,
            ],
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->requestServices->updateRequest($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \App\Models\Requests::findOrFail($id)->delete();
        return to_route('requests-admin.requestsIndex');
    }
}
