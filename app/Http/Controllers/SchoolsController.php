<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\School;
use Illuminate\Support\Facades\Storage;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(): Response
{
    $user = auth()->user(); // Assuming you're using Laravel's built-in authentication

    $schools = School::all()->map(function ($school) use ($user) {
        $deductSlot = $user->choosen_institution == $school->id 
                        && $user->choosen_school_id == $school->id;

        if ($deductSlot && $school->slots > 0) {
            $school->decrement('slots');
            $school->save(); // Save the updated slot count back to the database
        }

        return [
            'id' => $school->id,
            'name' => $school->name,
            'address' => $school->address,
            'school_logo' => asset('storage/' . $school->school_logo),
            'required_programs' => $school->required_programs,
            'skills' => $school->skills,
            'slots' => $school->slots,
        ];
    });

    return Inertia::render('Admin/Pages/Schools', [
        'schools' => $schools,
    ]);
}

    public function show($id)
    {
        $school = School::find($id);
        $school->delete();
        return to_route('schools.index');
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
            'required_programs' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'slots' => 'required|string|max:255',
        ]);

        if ($request->hasFile('schoolLogo')) {
            $schoolLogo = $request->file('schoolLogo')->store('SchoolLogo', 'public');
        } else {
            $schoolLogo = null;
        }
        School::create([
            'name' => $request->schoolName,
            'address' => $request->schoolAddress,
            'school_logo' => $schoolLogo,
            'required_programs' => $request->required_programs,
            'skills' => $request->skills,
            'slots' => $request->slots,
        ]);

        return Redirect::route('schools.index');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): Response
    {
        $school = School::findOrFail($id);


        return Inertia::render('Admin/Pages/Schools', [
            'schoolToEdit' => new SchoolResource($school),
            'image' => asset('storage/' . $school->school_logo)
        ]);
    }



    
    public function update(Request $request, $id)
    {
        try {
            $school = School::find($id);
            $request->validate([
                'schoolName' => 'required|string|max:255',
                'schoolAddress' => 'required|string|max:255',
                'required_programs' => 'required|string|max:255',
                'skills' => 'required|string|max:255',
                'slots' => 'required|string|max:255',
            ]);
    
            if ($request->hasFile('schoolLogo')) {
                if ($school->school_logo) {
                    Storage::delete('public/' . $school->school_logo);
                }
                $schoolLogo = $request->file('schoolLogo')->store('SchoolLogo', 'public');
            } else {
                $schoolLogo = $school->school_logo;
            }
            $school->update([
                'name' => $request->schoolName,
                'address' => $request->schoolAddress,
                'school_logo' => $schoolLogo,
                'required_programs' => $request->required_programs,
                'skills' => $request->skills,
                'slots' => $request->slots,
            ]);
    
            return redirect()->route('schools.index');
        } catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'Error updating school: ' . $e->getMessage());
        }
    }


    
    public function destroy(string $id)
    {
        //
    }
}
