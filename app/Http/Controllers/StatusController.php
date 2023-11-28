<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Institution;
use App\Models\School;
use App\Models\Schoolbsed;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
{
    if (Auth::check()) {
        $user = Auth::user();
        $id = $user->id;

        // Check if the logged-in user is the same as the requested student
        if ($user->approved == 1 && $user->is_admin == 0) {
            $student = User::findOrFail($id);

            // Check the student's program and set the matching institutions accordingly
            if ($student->program == 'BSED' || $student->program == 'BSED English' || $student->program == 'BSED Filipino' || $student->program == 'BSED Mathematics' || $student->program == 'BSED Science' || $student->program == 'BSED Social Studies') {
                $matchingInstitutions = Schoolbsed::where(function ($query) use ($student) {
                    $query->where(function ($innerQuery) use ($student) {
                        $innerQuery->whereIn('skills', explode(',', $student->skills));
                    });
                })
                ->get()
                ->map(function ($institution) {
                    return [
                        'id' => $institution->id,
                        'namebsed' => $institution->namebsed,
                        'address' => $institution->address,
                        'school_logo' => asset('storage/'. $institution->school_logo),
                        'required_programs' => $institution->required_programs,
                        'required_academic_performance' => $institution->required_academic_performance,
                        'skills' => $institution->skills,
                        'slots' => $institution->slots,
                    ];
                });
            } else {
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
                            'school_logo' => asset('storage/'. $institution->school_logo),
                            'required_programs' => $institution->required_programs,
                            'required_academic_performance' => $institution->required_academic_performance,
                            'skills' => $institution->skills,
                            'slots' => $institution->slots,
                        ];
                    });
            }

           // Get institutions that match the required_programs of the user for School and SchoolBSED
$requiredProgramsMatch = School::where('required_programs', 'LIKE', "%{$student->program}%")
->whereNotIn('id', $matchingInstitutions->pluck('id')) // Exclude institutions already matched by program and skills
->get()
->map(function ($institution) {
    return [
        'id' => $institution->id,
        'name' => $institution->name,
        'address' => $institution->address,
        'school_logo' => asset('storage/'. $institution->school_logo),
        'required_programs' => $institution->required_programs,
        'required_academic_performance' => $institution->required_academic_performance,
        'skills' => $institution->skills,
        'slots' => $institution->slots,
    ];
});

$requiredProgramsMatchbsed = Schoolbsed::where('required_programs', 'LIKE', "%{$student->program}%")
->whereNotIn('id', $matchingInstitutions->pluck('id')) // Exclude institutions already matched by program and skills
->get()
->map(function ($institution) {
    return [
        'id' => $institution->id,
        'namebsed' => $institution->namebsed,
        'address' => $institution->address,
        'school_logo' => asset('storage/'. $institution->school_logo),
        'required_programs' => $institution->required_programs,
        'required_academic_performance' => $institution->required_academic_performance,
        'skills' => $institution->skills,
        'slots' => $institution->slots,
    ];
});

$recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch)->concat($requiredProgramsMatchbsed);

            $student->recommended_institutions = $recommendedInstitutions;

            if ($student->choosen_institution != 0) {
                if ($student->program == 'BSED') {
                    $institution = Schoolbsed::findOrFail($student->choosen_institution);
                } else {
                    $institution = School::findOrFail($student->choosen_institution);
                }
                $institution->school_logo = asset('storage/'. $institution->school_logo);
                return Inertia::render('Student/StatusRecommended', [
                    'student' => $student,
                    'institution' => $institution,
                ]);
            } elseif ($student->is_off_campus == 1) {
               

                if ($student->program == 'BSED' || $student->program == 'BSED English' || $student->program == 'BSED Filipino' || $student->program == 'BSED Mathematics' || $student->program == 'BSED Science' || $student->program == 'BSED Social Studies') {
                    $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatchbsed);
                } else {
                    $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);
                }
                $student->recommended_institutions = $recommendedInstitutions;
                return Inertia::render('Student/StatusChooseRecommendation', [
                    'student' => $student,
                    
                ]);
                
                $student->recommended_institutions = $recommendedInstitutions;
            } else {
                return Inertia::render('Student/StatusWaiting', [
                    'student' => $student,
                ]);
            }
        }
    }

    // Return a default Inertia response or handle the case when Auth::check() is false.
    return Inertia::render('Student/StatusWaiting');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Student/StatusCreate');
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


    
        
        // $student = User::findOrFail($id);
    
        //     $institutions = Institution::where('required_programs', 'LIKE', "%{$student->program}%")->get();
    
        //     $recommendedInstitutions = [];
    
        //     foreach ($institutions as $institution) {
        //         if ($student->academic_performance >= $institution->required_academic_performance) {
        //             $recommendedInstitutions[] = $institution;
        //         }
        //     }
    
        //     $student->recommended_institutions = $recommendedInstitutions;
    
        //     return Inertia::render('Student/StatusCreate',[
        //         'student' => $student,
        //     ]);
        public function show($id)
{
    $institution = School::findOrFail($id);
    return Inertia::render('Student/StatusRecommended', [
        'institution' => School::findOrfail($id)->map(function($institution) {
            return [
                'id' => $school->id,
                'name' => $school->name,
                'address' => $school->address,
                'school_logo' => asset('storage/'. $school->school_logo),
                'required_programs' => $school->required_programs,
                'skills' => $school->skills,
            ];
        
        })
    ]);
}
  

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
    public function update(Request $request, $studentId, $institutionId)
{
   $student = User::find($studentId);
   $institution = School::find($institutionId);

   if ($student && $institution) {
       $student->choosen_institution = $institution->id; // Update the choosen_institution field with the institution ID
       $student->save();
   }

   return to_route('status.index');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
