<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Schoolbsed;
use App\Http\Resources\SchoolBSEDResource;
class AdminDashboardControllerBSED extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = User::where('approved', '=', 1)->where('is_admin', '=', 0)->where('program', 'BSED')->get();
        $totalStudents = $students->count();

        $deployed = User::where('is_admin', '=', 0)->where('program', 'BSED')->where('approved', '=', 1)->where('is_off_campus', '=', 1)->where('choosen_institution', '!=', 0)->get();
        $totalDeployed = $deployed->count();

        $newstudents = User::where('approved', '=', 0)->where('program', 'BSED')->get();
        $totalNewStudents = $newstudents->count();
    
        $schools = Schoolbsed::all();
        $totalSchools = $schools->count();
    
        return Inertia::render('Admin/PagesBSED/AdminDashboard',[
            'students' => UserResource::collection($students),
            'totalStudents' => $totalStudents,
            'deployed' => UserResource::collection($deployed),
            'totalDeployed' => $totalDeployed,
            'newstudents' => UserResource::collection($newstudents),
            'totalNewStudents' => $totalNewStudents,
            'schools' => SchoolBSEDResource::collection($schools),
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
