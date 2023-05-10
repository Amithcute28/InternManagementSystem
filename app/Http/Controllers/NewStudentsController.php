<?php

namespace App\Http\Controllers;

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

class NewStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // return Inertia::render('Admin/Pages/NewStudents',[
        //     'newstudents' => UserResource::collection(User::where('approved', '=', 0)->get()),
            
            $newstudents = User::where('approved', '=', 0)->get();
            $totalNewStudents = $newstudents->count();

            return Inertia::render('Admin/Pages/NewStudents',[
                'newstudents' => UserResource::collection($newstudents),
                'totalNewStudents' => $totalNewStudents,
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
    public function store(Request $request): RedirectResponse
    {
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $newstudent): Response
    {
        return Inertia::render('Admin/Pages/NewStudentsApproval', [
            'newstudent' => new UserResource($newstudent)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $newstudent): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255|' . Rule::unique('users', 'student_id')->ignore($newstudent),
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($newstudent),
            'birthday' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:255',



        ]);

        $newstudent->update([
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
            'approved' => 1,
        ]);

        return to_route('newstudents.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $newstudent): RedirectResponse
    {
        $newstudent->delete();
        return to_route('newstudents.index');
    }
}
