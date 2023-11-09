<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Institution;
use App\Models\User;
use App\Models\Schoolbsed;

class OffCampusControllerBSED extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = User::where('is_off_campus', '=', 1)
            ->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])
            ->where('approved', '=', 1)
            ->where('is_admin', '=', 0)
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
            $matchingInstitutions = Schoolbsed::where('required_programs', 'LIKE', "%{$student['program']}%")
                ->where(function ($query) use ($student) {
                    $query->whereIn('skills', explode(',', $student['skills']));
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

            $requiredProgramsMatch = Schoolbsed::where('required_programs', 'LIKE', "%{$student['program']}%")
                ->whereNotIn('id', $matchingInstitutions->pluck('id'))
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

            $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);

            $student['recommended_institutions'] = $recommendedInstitutions;
        });

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('is_off_campus', 1)->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/PagesBSED/OffCampus', [
            'students' => $students,
            'interns' => $interns,
            'totalInterns' => $totalInterns,
        ]);
    }


    /**
     * Recommend institutions for a student.
     */
    //     public function show(string $id)
    // {
    //     $student = Student::findOrFail($id);

    //     $institutions = Institution::where('required_programs', 'LIKE', "%{$student->program}%")->get();

    //     $recommendedInstitutions = [];

    //     foreach ($institutions as $institution) {
    //         if ($student->academic_performance >= $institution->required_academic_performance) {
    //             $recommendedInstitutions[] = $institution;
    //         }
    //     }

    //     $student->recommended_institutions = $recommendedInstitutions;

    //     if (count($recommendedInstitutions) > 0) {
    //         return Inertia::render('Admin/Pages/RecommendInstitution', [
    //             'student' => $student,
    //         ]);
    //     } else {
    //         return Inertia::render('Admin/Pages/WaitingToRecommend', [
    //             'student' => $student,
    //         ]);
    //     }
    // }

    public function show(string $id)
    {

        $student = User::findOrFail($id);

        // Get institutions that match the user's program and skills
        $matchingInstitutions = Schoolbsed::where('required_programs', 'LIKE', "%{$student->program}%")
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
        $requiredProgramsMatch = Schoolbsed::where('required_programs', 'LIKE', "%{$student->program}%")
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
            $institution = Schoolbsed::findOrFail($student->choosen_institution);
            $institution->school_logo = asset('storage/' . $institution->school_logo);
            return Inertia::render('Admin/PagesBSED/ViewOffCampus', [
                'student' => $student,
                'institution' => $institution,
            ]);
        } else {
            return Inertia::render('Admin/PagesBSED/WaitingOffCampus', [
                'student' => $student,
            ]);
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
