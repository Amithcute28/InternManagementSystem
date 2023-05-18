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
        return Inertia::render('Student/ApplicationIndex', [
            'application_forms' => ApplicationResource::collection(ApplicationForm::all())
        ]);
    }

    public function inCampusApplication()
    {
        // in-campus logic goes here

        $applicationForms = ApplicationForm::with('user')->get()->map(function ($application_form) {
            $user = $application_form->user;
            $student_name = $user ? $user->full_name : null;
            return [
                'id' => $user->id,
                'full_name' => $student_name,
                'program' => $user->program ?? null,
                'eslip' => $application_form->eslip ? asset('storage/' . $application_form->eslip) : null,
                'psa' => $application_form->psa ? asset('storage/' . $application_form->psa) : null,
                'pros' => $application_form->pros ? asset('storage/' . $application_form->pros) : null,
                'applicationF' => $application_form->applicationF ? asset('storage/' . $application_form->applicationF) : null,
                'medical' => $application_form->medical ? asset('storage/' . $application_form->medical) : null,
                'parent' => $application_form->parent ? asset('storage/' . $application_form->parent) : null,
                'twobytwo' => $application_form->twobytwo ? asset('storage/' . $application_form->twobytwo) : null,
            ];
        });

        $approvedUsers = User::where('approved', 1)->where('is_admin', 0)->whereDoesntHave('applicationForms')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'program' => $user->program,
                'eslip' => null, // Or any other default value for missing files
                'psa' => null,
                'pros' => null,
                'applicationF' => null,
                'medical' => null,
                'parent' => null,
                'twobytwo' => null,
                'status' => $user->status = 'Pending',
            ];
        });

        $combinedData = $applicationForms->concat($approvedUsers);

        $files = Storage::allFiles();
        $filtered_files = collect($files)->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        return Inertia::render('Admin/Pages/InCampusApplication', [
            'files' => $filtered_files,
            'approved' => $combinedData,
            // Add the offCampus route
        ]);
    }

    public function offCampusApplication()
    {
        // in-campus logic goes herea

        $qualifiedUsers = User::where('approved', 1)
            ->where('is_admin', 0)
            ->where('status', 'completed')
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form',);
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'id' => $user->id,
                    'student_id' => $user->student_id,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/' . $applicationForm->eval_form) : null) : null,

                ];
            });

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        return Inertia::render('Admin/Pages/OffCampusApplication', [
            'files' => $filtered_files,
            'offCampus' => $qualifiedUsers,
        ]);
    }

    public function updateStatus($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the status to "completed"
        $user->status = 'completed';
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
        $psa = '';
        $pros = '';
        $applicationF = '';
        $medical = '';
        $parent = '';
        $twobytwo = '';

        // Check if eslip file exists and store it
        if ($request->hasFile('eslip')) {
            $eslip = $request->file('eslip')->store('student', 'public');
        }

        // Check if other files exist and store them
        if ($request->hasFile('psa')) {
            $psa = $request->file('psa')->store('student', 'public');
        }
        if ($request->hasFile('pros')) {
            $pros = $request->file('pros')->store('student', 'public');
        }
        if ($request->hasFile('applicationF')) {
            $applicationF = $request->file('applicationF')->store('student', 'public');
        }
        if ($request->hasFile('medical')) {
            $medical = $request->file('medical')->store('student', 'public');
        }
        if ($request->hasFile('parent')) {
            $parent = $request->file('parent')->store('student', 'public');
        }
        if ($request->hasFile('twobytwo')) {
            $twobytwo = $request->file('twobytwo')->store('student', 'public');
        }

        // Create new application form record in the database
        ApplicationForm::create([
            'user_id' => $userId,
            'eslip' => $eslip,
            'psa' => $psa,
            'pros' => $pros,
            'applicationF' => $applicationF,
            'medical' => $medical,
            'parent' => $parent,
            'twobytwo' => $twobytwo,
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
        return to_route('admindash.index');
    }
}
