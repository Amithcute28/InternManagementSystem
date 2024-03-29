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

class ApplicationControllerBSED extends Controller
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

        $qualifiedUsers = User::where('approved', 1)
            ->where('is_admin', 0)
            ->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])
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
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/student/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                    'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
                ];
            });

            $perPage = request()->input('perPage') ?: 5;
            $filteredData = $qualifiedUsers->when(request()->input('search'), function ($collection, $search) {
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




        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 1)->where('is_off_campus', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/PagesBSED/InCampusApplication', [
            'files' => $filtered_files,
            'approved' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,
        ]);
    }

    public function offCampusApplication()
    {
        // in-campus logic goes herea

        $qualifiedUsers = User::where('approved', 1)->where('is_admin', 0)
        ->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])
            ->where('in_campus', 1)
            ->where('is_off_campus', 0)
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo', 'created_at');
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
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/student/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                    'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
                ];
            });

            $perPage = request()->input('perPage') ?: 5;
            $filteredData = $qualifiedUsers->when(request()->input('search'), function ($collection, $search) {
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

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 1)->where('is_off_campus', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/PagesBSED/OffCampusApplication', [
            'files' => $filtered_files,
            'offCampus' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
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



        return Redirect::route('applicationbsed.index');
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



        return Inertia::render('Admin/PagesBSED/OffCampusEdit', [

            'offCampus' => new UserResource($offCampus)
        ]);
    }

    public function updateIncampus($id)
    {
        $student = User::find($id);

        $student->in_campus = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('applicationsbsed.inCampusApplication');
    }

    public function updateOffcampus($id)
    {
        $student = User::find($id);


        $student->is_off_campus = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('applicationsbsed.offCampusApplication');
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
        return to_route('applicationsbsed.offCampusApplication');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $application)
    {
        $application->delete();
        return to_route('applicationsbsed.inCampusApplication');
    }
}
