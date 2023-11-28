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
use App\Models\Institution;
use Illuminate\Validation\Rules\Password;

class CoordinatorsControllerBSED extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
    
    // return Inertia::render('Admin/Pages/Coordinators', [
    //     'coordinators' => UserResource::collection(User::where('is_admin', 1)->get()),
        
    // ]);
    
    $students = User::where('is_admin', '=', 1)->where('approved', '=', 1)->get();

        return Inertia::render('Admin/PagesBSED/Coordinators', [
            'students' => UserResource::collection($students)
        ]);
          
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/PagesBSED/CoordinatorsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'student_id' => 'required|string|max:255',
            'program' => 'required|string|in:BEED,BSED',
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()],
        ]);


       
        $user = User::create([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
            'approved' => 1,


        ])->assignRole('admin');

        return to_route('coordinatorsbsed.index');
    }

    
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $coordinator): Response
    {
        return Inertia::render('Admin/PagesBSED/CoordinatorsEdit', [
            'coordinator' => new UserResource($coordinator)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $coordinator): RedirectResponse
    {
        $request->validate([
            
            'student_id' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($coordinator),
            'gender' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'birthday' => 'required|string|max:255',
            
            
            
        ]);

        $coordinator->update([
            'student_id' => $request->student_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'birthday' => $request->birthday,
            
        ]);

        


       

        return to_route('coordinatorsbsed.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $students = User::find($id);
        $students->delete();
        return to_route('coordinatorsbsed.index');
    }
}
