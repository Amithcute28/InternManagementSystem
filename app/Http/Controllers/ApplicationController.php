<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\ApplicationForm;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ApplicationResource;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Student/ApplicationIndex', [
            'application_forms' => ApplicationResource::collection(ApplicationForm::all())
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
    public function store(ApplicationRequest $request)

    {

        $userId = Auth::id();
        $eslip = '';
        $psa = '';
        $pros = '';
        $applicationF = '';
        $medical = '';
        $parent = '';
        $twobytwo = '';

        // Check if eslip file exists and store it
        if ($request->hasFile('eslip')) {
            $eslip = $request->file('eslip')->store('student', 'public');
        }

        // Check if other files exist and store them
        if ($request->hasFile('psa')) {
            $psa = $request->file('psa')->store('student', 'public');
        }
        if ($request->hasFile('pros')) {
            $pros = $request->file('pros')->store('student', 'public');
        }
        if ($request->hasFile('applicationF')) {
            $applicationF = $request->file('applicationF')->store('student', 'public');
        }
        if ($request->hasFile('medical')) {
            $medical = $request->file('medical')->store('student', 'public');
        }
        if ($request->hasFile('parent')) {
            $parent = $request->file('parent')->store('student', 'public');
        }
        if ($request->hasFile('twobytwo')) {
            $twobytwo = $request->file('twobytwo')->store('student', 'public');
        }

        // Create new application form record in the database
        ApplicationForm::create([
            'user_id' => $userId,
            'eslip' => $eslip,
            'psa' => $psa,
            'pros' => $pros,
            'applicationF' => $applicationF,
            'medical' => $medical,
            'parent' => $parent,
            'twobytwo' => $twobytwo,
            'approved' => 1,
            'is_admin' => 0,
        ]);



        return Redirect::route('application.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
