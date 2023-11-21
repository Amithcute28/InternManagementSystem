<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\ApplicationForm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;

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

class StudentsControllerBSED extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicationForms = ApplicationForm::with('user')->paginate(8)->map(function ($application_form) {
            $user = $application_form->user;
            $student_name = $user ? $user->full_name : null;
            return [
                'id' => $user->id,
                'student_id' => $user->student_id,
                'profile' => $user->profile,
                'is_off_campus' => $user->is_off_campus,
                'in_campus' => $user->in_campus,
                'full_name' => $student_name,
                'program' => $user->program ?? null,
                'eslip' => $application_form->eslip ? asset('storage/' . $application_form->eslip) : null,
                'psa' => $application_form->psa ? asset('storage/' . $application_form->psa) : null,
                'pros' => $application_form->pros ? asset('storage/' . $application_form->pros) : null,
                'applicationF' => $application_form->applicationF ? asset('storage/' . $application_form->applicationF) : null,
                'medical' => $application_form->medical ? asset('storage/' . $application_form->medical) : null,
                'parent' => $application_form->parent ? asset('storage/' . $application_form->parent) : null,
                'twobytwo' => $application_form->twobytwo ? asset('storage/' . $application_form->twobytwo) : null,
                'eval_form' => $application_form->eval_form ? asset('storage/' . $application_form->eval_form) : null,
            ];
        });
    
        $approvedUsers = User::where('approved', 1)
            ->where('is_admin', 0)
            ->whereDoesntHave('applicationForms')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'student_id' => $user->student_id,
                    'profile' => $user->profile,
                    'email' => $user->email,
                    'is_off_campus' => $user->is_off_campus,
                    'in_campus' => $user->in_campus,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'eslip' => null, // Or any other default value for missing files
                    'psa' => null,
                    'pros' => null,
                    'applicationF' => null,
                    'medical' => null,
                    'parent' => null,
                    'twobytwo' => null,
                    'eval_form' => null,
                ];
            });
    
        $combinedData = $applicationForms->concat($approvedUsers);
    
        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();
    
        $perPage = request()->input('perPage') ?: 5;

        $filteredData = $combinedData->when(request()->input('search'), function ($collection, $search) {
            return $collection->filter(function ($item) use ($search) {
                return stripos($item['student_id'], $search) !== false || stripos($item['full_name'], $search) !== false;
            });
        });
        
        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredData->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), $perPage),
            $filteredData->count(),
            $perPage,
            null,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        $paginateData = $paginatedData->appends(request()->query());
    
        
        $interns = User::where('approved', 1)->where('is_admin', 0)->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])->get();;
        $totalInterns = $interns->count();
        
        return Inertia::render('Admin/PagesBSED/Students', [
            'files' => $filtered_files,
            'approved' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,
            // Add the offCampus route
        ]);
    }
    public function edit($student): Response
    {

        $student = User::findOrFail($student);
        return Inertia::render('Admin/PagesBSED/StudentEdit', [
            'student' => new UserResource($student)
        ]);
    }

    public function inCampus()
    {
        // in-campus logic goes here

        $qualifiedUsers = User::where('approved', 1)->where('program', 'BEED')->where('is_admin', 0)->where('status', 'completed')->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo');
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'student_id' => $user->student_id,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/' . $applicationForm->twobytwo) : null) : null,
                ];
            });

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        return Inertia::render('Admin/PagesBSED/InCampus', [
            'files' => $filtered_files,
            'approved' => $qualifiedUsers,
        ]);
    }

    public function offCampus()
    {
        // in-campus logic goes here

        $qualifiedUsers = User::where('approved', 1)->where('program', 'BEED')->where('is_admin', 0)->where('is_off_campus', true)->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo');
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'student_id' => $user->student_id,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/' . $applicationForm->twobytwo) : null) : null,
                ];
            });

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        return Inertia::render('Admin/Pages/OffCampus', [
            'files' => $filtered_files,
            'approved' => $qualifiedUsers,
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
    public function store(RegisterRequest $request): RedirectResponse
    {

        $user = User::create([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => 0,
            'recommended' => 0,


        ])->assignRole('user');


        // $userId = $user->id;
        // $eslip = '';
        // $psa = '';
        // $pros = '';
        // $applicationF = '';
        // $medical = '';
        // $parent = '';
        // $twobytwo = '';

        // // Check if eslip file exists and store it
        // if ($request->hasFile('eslip')) {
        //     $eslip = $request->file('eslip')->store('student', 'public');
        // }

        // // Check if other files exist and store them
        // if ($request->hasFile('psa')) {
        //     $psa = $request->file('psa')->store('student', 'public');
        // }
        // if ($request->hasFile('pros')) {
        //     $pros = $request->file('pros')->store('student', 'public');
        // }
        // if ($request->hasFile('applicationF')) {
        //     $applicationF = $request->file('applicationF')->store('student', 'public');
        // }
        // if ($request->hasFile('medical')) {
        //     $medical = $request->file('medical')->store('student', 'public');
        // }
        // if ($request->hasFile('parent')) {
        //     $parent = $request->file('parent')->store('student', 'public');
        // }
        // if ($request->hasFile('twobytwo')) {
        //     $twobytwo = $request->file('twobytwo')->store('student', 'public');
        // }

        // // Create new application form record in the database
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




        return to_route('newstudentsbsed.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {

        $studentbsed = User::find($id);
        $request->validate([
            'student_id' => 'required|string|max:255|' . Rule::unique('users', 'student_id')->ignore($studentbsed),
            'program' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($studentbsed),
            'birthday' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:255',


        ]);
        $studentbsed->update([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'relationship' => $request->relationship,
            'nationality' => $request->nationality,
            'contact_number' => $request->contact_number,
            'home_address' => $request->home_address,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
        ]);

        return to_route('studentsbsed.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy($id): RedirectResponse
    {
        $student = User::find($id);
        $student->delete();
        return to_route('studentsbsed.index');
    }

    
}
