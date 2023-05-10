<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\School;



class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(): Response
    {
        return Inertia::render('Admin/Pages/Schools', [
            'schools' => School::all()->map(function($school) {
                return [
                    'id' => $school->id,
                    'school_name' => $school->school_name,
                    'school_address' => $school->school_address,
                    'school_logo' => asset('storage/'. $school->school_logo)
                ];
            
            })
           
        ]);

        
    }

    public function showSchoolsInfo(): Response
    {
        return Inertia::render('Admin/Pages/SchoolsInfo');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Pages/SchoolsInfo');
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
        ]);

        if ($request->hasFile('schoolLogo')) {
            $schoolLogo = $request->file('schoolLogo')->store('SchoolLogo', 'public');
        } else {
            $schoolLogo = null;
        }
        School::create([
            'school_name' => $request->schoolName,
            'school_address' => $request->schoolAddress,
            'school_logo' => $schoolLogo
        ]);

        return Redirect::route('schools.index'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        return Inertia::render('Admin/Pages/SchoolsInfo', [
            'school' => new SchoolResource($school),
            'image' => asset('storage/'. $school->school_logo)
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        return Inertia::render('Admin/Pages/SchoolsInfo', [
            'school' => new SchoolResource($school),
            'image' => asset('storage/'. $school->school_logo)
        ]);
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
