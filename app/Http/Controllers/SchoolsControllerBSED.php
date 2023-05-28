<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Schoolbsed;
use App\Http\Resources\SchoolBSEDResource;



class SchoolsControllerBSED extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(): Response
    {
        return Inertia::render('Admin/PagesBSED/Schools', [
            'schools' => Schoolbsed::all()->map(function($school) {
                return [
                    'id' => $school->id,
                    'namebsed' => $school->namebsed,
                    'address' => $school->address,
                    'school_logo' => asset('storage/'. $school->school_logo),
                    'required_programs' => $school->required_programs,
                    'skills' => $school->skills,
                ];
            
            })
           
        ]);

        
    }

    public function show(Schoolbsed $school)
    {
        return Inertia::render('Admin/PagesBSED/SchoolsInfo', [
            'school' => new SchoolBSEDResource($school),
        ]);
    }

    
    public function showSchoolsInfo(): Response
    {
        return Inertia::render('Admin/PagesBSED/SchoolsInfo');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/PagesBSED/SchoolsInfo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'schoolName' => 'required|string|max:255',
            'schoolAddress' => 'required|string|max:255',
            'schoolLogo' => 'nullable|file|mimes:jpeg,png|max:2048',
            'required_programs' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
        ]);

        if ($request->hasFile('schoolLogo')) {
            $schoolLogo = $request->file('schoolLogo')->store('SchoolLogo', 'public');
        } else {
            $schoolLogo = null;
        }
        Schoolbsed::create([
            'namebsed' => $request->schoolName,
            'address' => $request->schoolAddress,
            'school_logo' => $schoolLogo,
            'required_programs' => $request->required_programs,
            'skills' => $request->skills,
        ]);

        return Redirect::route('schoolsbsed.index'); 
    }

    /**
     * Display the specified resource.
     */
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schoolbsed $school)
    {
        return Inertia::render('Admin/PagesBSED/SchoolsInfo', [
            'school' => new SchoolBSEDResource($school),
            'image' => asset('storage/'. $school->school_logo)
        ]);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = User::find($id);

        if ($student) {
            $student->choosen_institution = $id; // Update the choosen_institution field with the institution ID
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
