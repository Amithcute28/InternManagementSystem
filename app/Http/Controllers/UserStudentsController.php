<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewInternRequest;
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
use Illuminate\Support\Facades\Auth;

class UserStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = Auth::user();

        if ($user->new_intern == 0) {
            return Inertia::render('Student/NewIntern', [
                'users' => UserResource::collection(User::where('id', '=', $user->id)->get()),
            ]);
        } else {
            return Inertia::render('Student/Main', [
                'users' => UserResource::collection(User::where('id', '=', $user->id)->get()),
            ]);
        }
    }

    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Student/Main', [
            'users' => new UserResource($user),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Student/Main', [
            'users' => new UserResource($user),
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
    public function store(Request $request)
    {

        // $twobytwo = '';

        // if ($request->hasFile('eslip')) {
        //     $eslip = $request->file('eslip')->store('student', 'public');
        // }

        // ApplicationForm::create([
        //     'user_id' => $userId,
        //     'eslip' => $eslip,
        //     'psa' => $psa,
        //     'pros' => $pros,
        //     'applicationF' => $applicationF,
        //     'medical' => $medical,
        //     'parent' => $parent,
        //     'twobytwo' => $twobytwo,
        //     'approved' => 1,
        //     'is_admin' => 0,
        // ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Student/ProfileEdit', [
            'user' => new UserResource($user)
        ]);
    }

    public function updateNewIntern(NewInternRequest $request, User $user): RedirectResponse
    {

        $user = Auth::user();
        $profile = '';

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile')->store('student', 'public');
        }

        $user->update([
            'skills' => $request->skills,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'relationship' => $request->relationaship,
            'nationality' => $request->nationality,
            'contact_number' => $request->contact_number,
            'home_address' => $request->home_address,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardina_contact,
            'new_intern' => 1,
            'profile' => $profile,


        ]);




        return to_route('user.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
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








        return to_route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $student->delete();
        return to_route('students.index');
    }
}
