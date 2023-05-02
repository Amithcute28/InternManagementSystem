<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\ApplicationForm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

// use App\Http\Resources\PermissionResource;
// use App\Http\Resources\RoleResource;
// use App\Http\Resources\StudentsResource;
// use App\Http\Resources\UserResource;
// use App\Models\User;
// use App\Models\Student;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules;
// use Inertia\Inertia;
// use Inertia\Response;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
// use App\Http\Requests\ProfileUpdateRequest;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = Storage::allFiles();
        $filtered_files = collect($files)->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $application_forms = ApplicationForm::all()->map(function ($application_form) {
            return [
                'id' => $application_form->id,
                'fname' => $application_form->fname,
                'lname' => $application_form->lname,
                'eslip' => asset('storage/' . $application_form->eslip),
                'psa' =>  asset('storage/' . $application_form->psa),
                'pros' => asset('storage/' . $application_form->pros),
                'applicationF' =>  asset('storage/' . $application_form->applicationF),
                'medical' =>  asset('storage/' . $application_form->medical),
                'parent' =>  asset('storage/' . $application_form->parent),
                'twobytwo' =>  asset('storage/' . $application_form->twobytwo),
            ];
        });

        return Inertia::render('Admin/Pages/Students', [    
            'files' => $filtered_files,
            'application_forms' => $application_forms
        ]);
    }

    
    // public function index()
    // {
    //     $files = Storage::allFiles();
    //     $filtered_files = collect($files)->filter(function ($value, $key) {
    //         $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    //         $extension = pathinfo($value, PATHINFO_EXTENSION);
    //         return in_array(strtolower($extension), $allowed_extensions);
    //     })->values();

    //     $application_forms = ApplicationForm::all()->map(function ($application_form) {
    //         return [
    //             'id' => $application_form->id,
    //             'fname' => $application_form->fname,
    //             'lname' => $application_form->lname,
    //             'eslip' => asset('storage/' . $application_form->eslip),
    //             'psa' =>  asset('storage/' . $application_form->psa),
    //             'pros' => asset('storage/' . $application_form->pros),
    //             'applicationF' =>  asset('storage/' . $application_form->applicationF),
    //             'medical' =>  asset('storage/' . $application_form->medical),
    //             'parent' =>  asset('storage/' . $application_form->parent),
    //             'twobytwo' =>  asset('storage/' . $application_form->twobytwo),
    //         ];
    //     });

    //     return Inertia::render('Admin/Pages/Students', [    
    //         'files' => $filtered_files,
    //         'application_forms' => $application_forms
    //     ]);
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Pages/StudentCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
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

        $user = User::create([
            'student_id' => $request->student_id,
            'password' => Hash::make($request->password),
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
        ])->assignRole('user');

        

        return to_route('students.index');
    }

    
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student): Response
    {
        return Inertia::render('Admin/Pages/StudentEdit', [
            'student' => new UserResource($student)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255|'.Rule::unique('users', 'student_id')->ignore($student),
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|'.Rule::unique('users', 'email')->ignore($student),
            'birthday' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:255',
            'approved' => 'required|string|max:255',
            
            
        ]);

        $student->update([
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
            'approved' => $request->approved,
        ]);

       

        


       

        return to_route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student): RedirectResponse
    {
        $student->delete();
        return to_route('students.index');
    }
}
