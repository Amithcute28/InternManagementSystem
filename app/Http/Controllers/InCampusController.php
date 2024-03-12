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
use App\Models\School;

class InCampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request): Response
    {
        $students = User::where('approved', 1)->where('is_admin', 0)
        ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
        ->where('in_campus', 0)
        ->where('applications', 1)
        ->where('is_off_campus', 0)
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo');
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
                    'skills' => $user->skills,
                    'student_school_name' => $user->student_school_name,
                    'in_campus' => $user->in_campus,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/student/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                ];
            });

        $students->each(function ($student) {
            $matchingInstitutions = School::where('required_programs', 'LIKE', "%{$student['program']}%")
                ->where(function ($query) use ($student) {
                    $query->whereIn('skills', explode(',', $student['skills']));
                })
                ->get()
                ->map(function ($institution) {
                    return [
                        'id' => $institution->id,
                        'name' => $institution->name,
                        'address' => $institution->address,
                        'school_logo' => asset('storage/student/' . $institution->school_logo),
                        'required_programs' => $institution->required_programs,
                        'required_academic_performance' => $institution->required_academic_performance,
                        'skills' => $institution->skills,
                    ];
                });

            $requiredProgramsMatch = School::where('required_programs', 'LIKE', "%{$student['program']}%")
                ->whereNotIn('id', $matchingInstitutions->pluck('id'))
                ->get()
                ->map(function ($institution) {
                    return [
                        'id' => $institution->id,
                        'name' => $institution->name,
                        'address' => $institution->address,
                        'school_logo' => asset('storage/' . $institution->school_logo),
                        'required_programs' => $institution->required_programs,
                        'required_academic_performance' => $institution->required_academic_performance,
                        'skills' => $institution->skills,
                    ];
                });

            $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);

            $student['recommended_institutions'] = $recommendedInstitutions;
        });

        $perPage = request()->input('perPage') ?: 5;
        $filteredData = $students->when(request()->input('search'), function ($collection, $search) {
            return $collection->filter(function ($item) use ($search) {
                return stripos($item['student_id'], $search) !== false || stripos($item['full_name'], $search) !== false || stripos($item['student_school_name'], $search) !== false;
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

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 0)->where('applications', 1)->where('is_off_campus', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();

       
        return Inertia::render('Admin/Pages/InCampus', [
            'students' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,
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

        $student = User::findOrFail($id);

        // Get institutions that match the user's program and skills
        $matchingInstitutions = School::where('required_programs', 'LIKE', "%{$student->program}%")
            ->where(function ($query) use ($student) {
                $query->where(function ($innerQuery) use ($student) {
                    $innerQuery->whereIn('skills', explode(',', $student->skills));
                });
            })
            ->get()
            ->map(function ($institution) {
                return [
                    'id' => $institution->id,
                    'name' => $institution->name,
                    'address' => $institution->address,
                    'school_logo' => asset('storage/' . $institution->school_logo),
                    'required_programs' => $institution->required_programs,
                    'required_academic_performance' => $institution->required_academic_performance,
                    'skills' => $institution->skills,
                ];
            });

        // Get institutions that match the required_programs of the user
        $requiredProgramsMatch = School::where('required_programs', 'LIKE', "%{$student->program}%")
            ->whereNotIn('id', $matchingInstitutions->pluck('id')) // Exclude institutions already matched by program and skills
            ->get()
            ->map(function ($institution) {
                return [
                    'id' => $institution->id,
                    'name' => $institution->name,
                    'address' => $institution->address,
                    'school_logo' => asset('storage/' . $institution->school_logo),
                    'required_programs' => $institution->required_programs,
                    'required_academic_performance' => $institution->required_academic_performance,
                    'skills' => $institution->skills,
                ];
            });

        $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);

        $student->recommended_institutions = $recommendedInstitutions;



        if ($student->choosen_institution != 0) {
            $institution = School::findOrFail($student->choosen_institution);
            $institution->school_logo = asset('storage/' . $institution->school_logo);
            return Inertia::render('Admin/Pages/ViewOffCampusFirst', [
                'student' => $student,
                'institution' => $institution,
            ]);
        } else {
            return Inertia::render('Admin/Pages/WaitingOffCampusFirst', [
                'student' => $student,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function updateEval(Request $request, $id)
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $student = User::find($id);

        $student->in_campus = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('first-shift.index');
    }

    public function updateIncampus($id)
    {
        $student = User::find($id);

        $student->in_campus = 1;
        $student->applications = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('applications.inCampusApplication');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
