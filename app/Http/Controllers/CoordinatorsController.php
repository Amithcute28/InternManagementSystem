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

class CoordinatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
    
    return Inertia::render('Admin/Pages/Coordinators', [
        'coordinators' => UserResource::collection(User::where('is_admin', 1)->get()),
        
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Pages/CoordinatorsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        /** 
         *  SRP (Single Responsibility Principle)
         *  Use FormRequest for validation instead of the validate
         */
        $request->validate([
            'student_id' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'gender' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'birthday' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
        ]);

        User::create([
            
            /**
             * Set is_admin column to 1 when saving
             * to make the user an admin.
             */
            // 'is_admin' => 1,
            
            'student_id' => $request->student_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'birthday' => $request->birthday,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
            
        ])->assignRole('admin');

        

        return to_route('coordinators.index');
    }

    
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $coordinator): Response
    {
        return Inertia::render('Admin/Pages/CoordinatorsEdit', [
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

        


       

        return to_route('coordinators.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( User $coordinator): RedirectResponse
    {
        $coordinator->delete();
        return to_route('coordinators.index');
    }
}
