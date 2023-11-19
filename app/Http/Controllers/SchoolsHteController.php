<?php

namespace App\Http\Controllers;
use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\School;


class SchoolsHteController extends Controller
{
    protected $allowedMethods = ['index', 'create', 'store', 'edit', 'update', 'destroy', 'schoolsDestroy'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Pages/Schools', [
            'schools' => School::all()->map(function ($school) {
                return [
                    'id' => $school->id,
                    'name' => $school->name,
                    'address' => $school->address,
                    'school_logo' => asset('storage/' . $school->school_logo),
                    'required_programs' => $school->required_programs,
                    'skills' => $school->skills,
                ];
            })

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

     public function show($id): RedirectResponse
    {
        $school = School::find($id);
        $school->delete();
        return to_route('schools.index');
    }

    public function create()
    {
        //
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
        School::create([
            'name' => $request->schoolName,
            'address' => $request->schoolAddress,
            'school_logo' => $schoolLogo,
            'required_programs' => $request->required_programs,
            'skills' => $request->skills,
        ]);

        return Redirect::route('schools.index');
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): RedirectResponse
    {
        $schools = School::find($id);
        return Inertia::render('Admin/Pages/SchoolsEdit', [
            'school' => new SchoolResource($schools)
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
   

    public function destroy($id): RedirectResponse
    {
        $school = School::find($id);
        $school->delete();
        return to_route('schools.index');
    }

    public function schoolsDestroy($id): RedirectResponse
     {
        $school = School::find($id);
         $school->delete();
         return redirect()->route('schools.index');
     }
}
