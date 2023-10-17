<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\ApplicationForm;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = Auth::user();

        return Inertia::render('Student/ApplicationIndex', [
            'application_forms' => ApplicationResource::collection(ApplicationForm::where('user_id', $user->id)->get() ?? []),
        ]);
    }

    public function inCampusApplication()
{
    // in-campus logic goes here

    $qualifiedUsers = User::where('approved', 1)
    ->where('is_admin', 0)
    ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
    ->where(function ($query) {
        $query->where('in_campus', 0)
            ->orWhere(function ($query) {
                $query->where('in_campus', 1)->doesntHave('applicationForms');
            });
    })
    ->with(['applicationForms' => function ($query) {
        $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo', 'created_at');
    }])
    ->get()
    ->map(function ($user) {
        $applicationForm = $user->applicationForms->first(); // Get the first application form

        return [
            'id' => $user->id,
            'student_id' => $user->student_id,
            'profile' => $user->profile,
            'email' => $user->email,
            'full_name' => $user->full_name,
            'program' => $user->program,
            'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/' . $applicationForm->eval_form) : null) : null,
            'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/' . $applicationForm->eslip) : null) : null,
            'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/' . $applicationForm->psa) : null) : null,
            'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/' . $applicationForm->pros) : null) : null,
            'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/' . $applicationForm->applicationF) : null) : null,
            'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/' . $applicationForm->medical) : null) : null,
            'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/' . $applicationForm->parent) : null) : null,
            'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/' . $applicationForm->twobytwo) : null) : null,
            'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
        ];
    });




    $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
        $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $allowed_extensions);
    })->values();

    $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
    $totalInterns = $interns->count();

    return Inertia::render('Admin/Pages/InCampusApplication', [
        'files' => $filtered_files,
        'approved' => $qualifiedUsers,
        'interns' => $interns,
        'totalInterns' => $totalInterns,
    ]);
}

    public function offCampusApplication()
    {
        // in-campus logic goes herea

        $qualifiedUsers = User::where('approved', 1)->where('is_admin', 0)
        ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
        ->where('in_campus', 1)
        ->where('is_off_campus', 0)
        ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form','eslip','psa','pros','applicationF','medical','parent','twobytwo', 'created_at');
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'id' => $user->id,
                    'student_id' => $user->student_id,
                    'email' => $user->email,
                    'profile' => $user->profile,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'in_campus' => $user->in_campus,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/' . $applicationForm->twobytwo) : null) : null,
                    'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
                ];
            });

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 1)->where('is_off_campus', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/Pages/OffCampusApplication', [
            'files' => $filtered_files,
            'offCampus' => $qualifiedUsers,
            'interns' => $interns,
            'totalInterns' => $totalInterns,
        ]);
    }

    public function updateStatus($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the status to "completed"
        $user->in_campus = 1;
        $user->save();

        return back()->with('success', 'Status updated successfully.');
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function addEvaluation(Request $request)
    {


        $request->validate([
            'evalForm' => 'nullable|file|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('evalForm')) {
            $evalForm = $request->file('evalForm')->store('atudent', 'public');
        } else {
            $evalForm = null;
        }

        ApplicationForm::create([
            'eval_form' => $evalForm
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationRequest $request)

    {


        $userId = Auth::id();
        $eslip = '';
        $origEslip = '';
        $psa = '';
        $origPsa = '';
        $pros = '';
        $origPros = '';
        $applicationF = '';
        $origApplicationF = '';
        $medical = '';
        $origMedical = '';
        $parent = '';
        $origParent = '';
        $twobytwo = '';
        $origTwobytwo = '';


        // if ($request->hasFile('eslip')) {
        //     $eslip = $request->file('eslip')->store('student', 'public');
        // }

        if ($request->hasFile('eslip')) {
            $eslip = $request->file('eslip');
            $originalFileName = $eslip->getClientOriginalName();

            $count = 1;
            $origEslip = $originalFileName;
            while (Storage::exists('public/student/' . $origEslip)) {
                // Append a counter to the file name to make it unique
                $origEslip = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $eslip->getClientOriginalExtension();
                $count++;
            }
            $eslip->storeAs('public/student', $origEslip);
        }
        // if ($request->hasFile('psa')) {
        //     $psa = $request->file('psa')->store('student', 'public');
        // }

        if ($request->hasFile('psa')) {
            $psa = $request->file('psa');
            $originalFileName = $psa->getClientOriginalName();
            $origPsa = $originalFileName;

            $count = 1;
            while (Storage::exists('public/student/' . $origPsa)) {
                // Append a counter to the file name to make it unique
                $origPsa = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $psa->getClientOriginalExtension();
                $count++;
            }
            $psa->storeAs('public/student', $origPsa);
        }
        // if ($request->hasFile('pros')) {
        //     $pros = $request->file('pros')->store('student', 'public');
        // }

        if ($request->hasFile('pros')) {
            $pros = $request->file('pros');
            $originalFileName = $pros->getClientOriginalName();
            $origPros = $originalFileName;

            $count = 1;
            while (Storage::exists('public/student/' . $origPros)) {
                // Append a counter to the file name to make it unique
                $origPros = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $pros->getClientOriginalExtension();
                $count++;
            }
            $pros->storeAs('public/student', $origPros);
        }
        // if ($request->hasFile('applicationF')) {
        //     $applicationF = $request->file('applicationF')->store('student', 'public');
        // }

        if ($request->hasFile('applicationF')) {
            $applicationF = $request->file('applicationF');
            $originalFileName = $applicationF->getClientOriginalName();
            $origApplicationF = $originalFileName;

            $count = 1;
            while (Storage::exists('public/student/' . $origApplicationF)) {
                // Append a counter to the file name to make it unique
                $origApplicationF = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $applicationF->getClientOriginalExtension();
                $count++;
            }
            $applicationF->storeAs('public/student', $origApplicationF);
        }
        // if ($request->hasFile('medical')) {
        //     $medical = $request->file('medical')->store('student', 'public');
        // }

        if ($request->hasFile('medical')) {
            $medical = $request->file('medical');
            $originalFileName = $medical->getClientOriginalName();
            $origMedical = $originalFileName;

            $count = 1;
            while (Storage::exists('public/student/' . $origMedical)) {
                // Append a counter to the file name to make it unique
                $origMedical = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $medical->getClientOriginalExtension();
                $count++;
            }
            $medical->storeAs('public/student', $origMedical);
        }
        // if ($request->hasFile('parent')) {
        //     $parent = $request->file('parent')->store('student', 'public');
        // }

        if ($request->hasFile('parent')) {
            $parent = $request->file('parent');
            $originalFileName = $parent->getClientOriginalName();
            $origParent = $originalFileName;

            $count = 1;
            while (Storage::exists('public/student/' . $origParent)) {
                // Append a counter to the file name to make it unique
                $origParent = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $parent->getClientOriginalExtension();
                $count++;
            }
            $parent->storeAs('public/student', $origParent);
        }
        // if ($request->hasFile('twobytwo')) {
        //     $twobytwo = $request->file('twobytwo')->store('student', 'public');
        // }

        if ($request->hasFile('twobytwo')) {
            $twobytwo = $request->file('twobytwo');
            $originalFileName = $twobytwo->getClientOriginalName();
            $origTwobytwo = $originalFileName;

            $count = 1;
            while (Storage::exists('public/student/' . $origTwobytwo)) {
                // Append a counter to the file name to make it unique
                $origTwobytwo = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . $count . '.' . $twobytwo->getClientOriginalExtension();
                $count++;
            }
            $twobytwo->storeAs('public/student', $origTwobytwo);
        }

        ApplicationForm::create([
            'user_id' => $userId,
            'eslip' => $origEslip,
            'psa' => $origPsa,
            'pros' => $origPros,
            'applicationF' => $origApplicationF,
            'medical' => $origMedical,
            'parent' => $origParent,
            'twobytwo' => $origTwobytwo,
            'approved' => 1,
            'is_admin' => 0,
        ]);

        return Redirect::route('application.index');
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
    public function edit($application): Response
    {



        $offCampus = User::findOrFail($application);



        return Inertia::render('Admin/Pages/OffCampusEdit', [

            'offCampus' => new UserResource($offCampus)
        ]);
    }
    
    public function updateIncampus($id)
    {
        $student = User::find($id);
        
            $student->in_campus = 1;
            $student->save();
        
        
        // Add any additional logic or response handling as needed
        
        return redirect()->route('applications.inCampusApplication');
    }

    public function updateOffcampus($id)
    {
        $student = User::find($id);
        
      
            $student->is_off_campus = 1;
            $student->save();
        
        
        // Add any additional logic or response handling as needed
        
        return redirect()->route('applications.offCampusApplication');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Retrieve the user record from the database
        $user = User::findOrFail($id);

        // Retrieve the associated application record
        $application = ApplicationForm::where('user_id', $id)->first();

        // Validate the incoming request data
        $request->validate([
            'evalForm' => 'nullable|file',
        ]);

        // Handle the evaluation form file if provided
        if ($request->hasFile('evalForm')) {
            $evalForm = $request->file('evalForm')->store('student', 'public');
            $application->eval_form = $evalForm;
        }

        // Save the updated application record
        $application->user()->associate($user); // Associate the user with the application
        $application->save();

        // Redirect back to the previous page or show a success message
        return to_route('applications.offCampusApplication');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $application)
    {
        $application->delete();
        return to_route('applications.inCampusApplication');
    }
}
