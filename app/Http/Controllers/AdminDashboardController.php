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
public function index(): Response
{
    $students = User::where('approved', '=', 1)->where('is_admin', '=', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
    $totalStudents = $students->count();

    $deployed = User::where('is_admin', '=', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->where('approved', '=', 1)->where('is_off_campus', '=', 1)->where('choosen_institution', '!=', 0)->get();
    $totalDeployed = $deployed->count();

    $newstudents = User::where('approved', '=', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
    $totalNewStudents = $newstudents->count();

    $schools = School::all();
    $totalSchools = $schools->count();

    return Inertia::render('Admin/Pages/AdminDashboard',[
        'students' => UserResource::collection($students),
        'totalStudents' => $totalStudents,
        'deployed' => UserResource::collection($deployed),
        'totalDeployed' => $totalDeployed,
        'newstudents' => UserResource::collection($newstudents),
        'totalNewStudents' => $totalNewStudents,
        'schools' => SchoolResource::collection($schools),
        'totalSchools' => $totalSchools,
    ]);
}

    public function create()
    { 
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
