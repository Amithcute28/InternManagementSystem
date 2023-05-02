<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\School;
use App\Http\Resources\SchoolResource;
class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = User::where('approved', '=', 1)->where('is_admin', '=', 0)->get();
        $totalStudents = $students->count();
    
        $schools = School::all();
        $totalSchools = $schools->count();
    
        return Inertia::render('Admin/Pages/AdminDashboard',[
            'students' => UserResource::collection($students),
            'totalStudents' => $totalStudents,
            'schools' => SchoolResource::collection($schools),
            'totalSchools' => $totalSchools,
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
    public function store(Request $request)
    {
        //
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
