<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Http\Resources\UserResource;
use App\Http\Resources\StudentsResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;   
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Student/Main', [
            'usersprofile' => UserResource::collection(User::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $student): Response
    {
        return Inertia::render('Student/ProfileEdit', [
            'student' => new UserResource($student)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student, string $id): Response
    {
        return Inertia::render('Student/Main', [
            'student' => new UserResource($student)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student): RedirectResponse
    {
        $request->validate([
            
            'student_id' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($student),
            'gender' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'birthday' => 'required|string|max:255',
            
            
            
        ]);

        $student->update([
            'student_id' => $request->student_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'birthday' => $request->birthday,
            
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( User $userprofile): RedirectResponse
    {
        $userprofile->delete();
        return to_route('user.index');
    }
}

