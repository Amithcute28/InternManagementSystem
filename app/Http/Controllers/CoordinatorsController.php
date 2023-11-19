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
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\Rules\Password;

class CoordinatorsController extends Controller
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

        return Inertia::render('Admin/Pages/Coordinators', [
            'students' => UserResource::collection($students)
        ]);
          
    }

    /**
     * Show the form for creating a new resource.
     */
    


    public function show($id): RedirectResponse
    {
      
    }
    
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'student_id' => 'required|string|max:255',
            'program' => 'required|string|in:BEED,BECEd,BSNEd,BPEd,BSED English,BSED Filipino,BSED Mathematics,BSED Science,BSED Social Studies',
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

        return to_route('coordinators.index');
    }

    public function update(Request $request)
    {
        
    }

    public function delete()
    {
       
    }

    

    public function destroy($id): RedirectResponse
    {
        $students = User::find($id);
        $students->delete();
        return to_route('coordinators.index');
    }

    private function deleteProfileImage($imagePath)
    {
        // Delete the profile image file from storage
        Storage::delete($imagePath);
    }
}