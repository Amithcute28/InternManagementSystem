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
use Illuminate\Support\Facades\Auth;



class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $user = Auth::user();
        return Inertia::render('Admin/Pages/AdminProfile', [
            'users' => UserResource::collection(User::where('id', '=', $user->id)->get()),
        ]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        $user = User::findOrFail($user);
        return Inertia::render('Admin/Pages/AdminProfileEdit', [
            'user' => new UserResource($user)
        ]);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::find($id);
        $request->validate([
            'student_id' => 'required|string|max:255|' . Rule::unique('users', 'student_id')->ignore($user),
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($user),
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
            'home_address' => $request->home_address,
            'zip_code' => $request->zip_code,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
        ]);








        return to_route('adminProfile.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
