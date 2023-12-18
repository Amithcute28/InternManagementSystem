<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Models\ApplicationForm;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = Auth::user();
        $applicationForm = ApplicationForm::where('user_id', $user->id)->first();

        return Inertia::render('Student/ApplicationIndex', [
            'application_forms' => $applicationForm ? new ApplicationResource($applicationForm) : null,
        ]);
    }


    public function inCampusApplication()
    {
        // in-campus logic goes here

        $qualifiedUsers = User::where('approved', 1)
            ->where('is_admin', 0)
            ->where('applications', 0)
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

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 0)->where('applications', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/Pages/InCampusApplication', [
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
            ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
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

        return Inertia::render('Admin/Pages/OffCampusApplication', [
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
        $eslip = null;
        $origEslip = null;
        $psa = null;
        $origPsa = null;
        $pros = null;
        $origPros = null;
        $applicationF = null;
        $origApplicationF = null;
        $medical = null;
        $origMedical = null;
        $parent = null;
        $origParent = null;
        $twobytwo = null;
        $origTwobytwo = null;


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
    public function show($id)
    {

        $internApplicationToEdit = ApplicationForm::findOrFail($id);

        return Inertia::render('Student/ApplicationIndex', [

            'internApplicationToEdit' => new ApplicationResource($internApplicationToEdit)
        ]);
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

    public function editInternApplication($id)
    {

        $internApplicationToEdit = ApplicationForm::findOrFail($id);

        return Inertia::render('Student/ApplicationIndex', [

            'internApplicationToEdit' => new ApplicationResource($internApplicationToEdit)
        ]);
    }

    public function updateInternApplication(Request $request)
    {
        $applicationForm = ApplicationForm::findOrFail($request->input('id'));

        $fileRules = [];

        // Add validation rule for 'eslip' only if it's present in the request
        if ($request->hasFile('eslip')) {
            $fileRules['eslip'] = 'pdf_file|max:10240';
        }

        // Add validation rule for 'psa' only if it's present in the request
        if ($request->hasFile('psa')) {
            $fileRules['psa'] = 'pdf_file|max:10240';
        }

        if ($request->hasFile('pros')) {
            $fileRules['pros'] = 'pdf_file|max:10240';
        }

        if ($request->hasFile('applicationF')) {
            $fileRules['applicationF'] = 'pdf_file|max:10240';
        }

        if ($request->hasFile('medical')) {
            $fileRules['medical'] = 'pdf_file|max:10240';
        }

        if ($request->hasFile('parent')) {
            $fileRules['parent'] = 'pdf_file|max:10240';
        }

        if ($request->hasFile('twobytwo')) {
            $fileRules['twobytwo'] = 'image_file|max:10240';
        }

        // ... similarly for other file inputs ...

        $validator = Validator::make($request->all(), $fileRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        }

        foreach ($fileRules as $fieldName => $rule) {
            if ($request->hasFile($fieldName)) {
                $file = $this->processFile($request, $fieldName, 'public/student', $applicationForm->$fieldName);
                if ($file !== null) {
                    $applicationForm->$fieldName = $file;
                }
            }
        }

        $applicationForm->save();

        return redirect()->route('application.index')->with(['success' => true]);
    }

    private function processFile($request, $fieldName, $storagePath, $existingFilePath)
    {
        if ($request->hasFile($fieldName)) {
            // Delete the existing file if present
            if ($existingFilePath) {
                Storage::delete('public/' . $storagePath . '/' . $existingFilePath);
            }

            // Retrieve the uploaded file
            $file = $request->file($fieldName);
            $originalFileName = $file->getClientOriginalName();
            $fileBaseName = pathinfo($originalFileName, PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();

            // Generate a unique file name
            $count = 1;
            $newFileName = $originalFileName; // Start with the original file name
            while (Storage::disk('public')->exists($storagePath . '/' . $newFileName)) {
                // If file exists, append a counter to the file name
                $newFileName = $fileBaseName . '-' . $count . '.' . $fileExtension;
                $count++;
            }

            // Store the file with the unique name
            $storedFilePath = $file->storeAs($storagePath, $newFileName, 'public');

            // Remove the 'public/' prefix from the stored file path
            $relativeFilePath = str_replace('public/student/', '', $storedFilePath);

            // Return the relative file path
            return $relativeFilePath;
        }
        return null; // Return null if no new file is uploaded
    }


    public function deleteInternApplication(Request $request, $id)
    {
        $student = User::find($id);

        
        $student->applications = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('applications.inCampusApplication');
    }

    public function updateIncampusDone($id)
    {
        // Fetch the field name directly from the request
        $fieldName = $request->input('field');

        // Ensure the field name is not null before proceeding
        if ($fieldName) {
            $applicationForm = ApplicationForm::findOrFail($id);
            $filePath = $applicationForm->$fieldName;

            if ($filePath) {
                Storage::disk('public')->delete('student/' . $filePath);
                $applicationForm->$fieldName = null;
                $applicationForm->save();

                return redirect()->route('application.index');
            }
        }
        // Handle situations where the field name is null or not found
        // You might want to return an error response or handle it differently based on your requirements.
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
    public function destroy($id): RedirectResponse
    {
        $application = User::find($id);
        $application->delete();
        return to_route('applications.inCampusApplication');
    }
}
