<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\School;


class SchoolsDeleteController extends Controller
{
    // public function index(): Response
    public function index(): Response
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

    
    public function show($id): RedirectResponse
    {
       $school = School::find($id);
        $school->delete();
        return redirect()->route('schools.index');
    }

    public function schoolsDestroy($id): RedirectResponse
     {
        $school = School::find($id);
         $school->delete();
         return redirect()->route('schools.index');
     }
}
