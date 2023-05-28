<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeachingPractice;
use App\Http\Resources\UserResource;
use App\Http\Resources\StudentsResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Models\Institution;
use App\Models\Student;
use App\Models\School;

class RecommenderController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // return Inertia::render('Admin/Pages/Recommender', [
        //     'recommenders' => UserResource::collection(User::where('is_admin', 1)->get()),
            
        // ]);

        $students = User::where('recommended', '=', 0)->where('approved', '=', 1)->where('is_admin', '=', 0)->where('status', '=', 'completed')->get();

        $institutions = School::all();

        foreach ($students as $student) {
            $student->recommended_institutions = [];
        }

        return Inertia::render('Admin/Pages/Recommender', [
            'students' => $students,
        ]);
    }

        public function show(string $id)
        {
            
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
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $student = User::findOrFail($id);

    // Get institutions that match the user's program and skills
    $matchingInstitutions = School::where('required_programs', 'LIKE', "%{$student->program}%")
        ->where(function ($query) use ($student) {
            $query->where(function ($innerQuery) use ($student) {
                $innerQuery->whereRaw("FIND_IN_SET('Computer', skills) > 0");
                $innerQuery->orWhereIn('skills', explode(',', $student->skills));
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

    return Inertia::render('Admin/Pages/RecommendInstitution', [
        'student' => $student,
    ]);
}

    public function updateRecommender($id) {

      
        
        $user = User::findOrFail($id);
        dd($user);
        $user->recommended = 1;
        $user->save();

        return to_route('recommender.index');
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $student = User::find($id);
        
      
            $student->recommended = 1;
            $student->save();
        
        
        // Add any additional logic or response handling as needed
        
        return redirect()->route('recommender.index');
    }

    public function updateInstitution(Request $request, $id)
    {
        $student = User::find($id);
        $institutionId = Institution::find($id);

        if ($student) {
            $student->choosen_institution = $institutionId; // Update the choosen_institution field with the institution ID
            $student->save();
        }

        return redirect()->route('recommender.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
