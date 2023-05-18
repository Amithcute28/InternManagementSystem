<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Institution;
use App\Models\User;
use App\Models\School;

class OffCampusController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = User::where('recommended', '=', 1)->where('approved', '=', 1)->where('is_admin', '=', 0)->get();

        $institutions = Institution::all();

        foreach ($students as $student) {
            $student->recommended_institutions = [];
        }

        return Inertia::render('Admin/Pages/OffCampus', [
            'students' => $students,
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
            'school_logo' => asset('storage/'. $institution->school_logo),
            'required_programs' => $institution->required_programs,
            'required_academic_performance' => $institution->required_academic_performance,
            'skills' => $institution->skills,
        ];
    });

$recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);

$student->recommended_institutions = $recommendedInstitutions;


    
            if ($student->choosen_institution != 0) {
                $institution = School::findOrFail($student->choosen_institution);
                $institution->school_logo = asset('storage/'. $institution->school_logo);
                return Inertia::render('Admin/Pages/ViewOffCampus', [
                    'student' => $student,
                    'institution' => $institution,
                ]);
            } else {
                return Inertia::render('Admin/Pages/WaitingOffCampus', [
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
