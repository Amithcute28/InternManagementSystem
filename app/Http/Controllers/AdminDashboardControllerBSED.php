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
   
    public function index(): Response
    {
        $students = User::where('approved', '=', 1)->where('is_admin', '=', 0)->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])->get();
        $totalStudents = $students->count();

        $deployed = User::where('is_admin', '=', 0)->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])->where('approved', '=', 1)->where('is_off_campus', '=', 1)->where('choosen_institution', '!=', 0)->get();
        $totalDeployed = $deployed->count();

        $newstudents = User::where('approved', '=', 0)->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])->get();
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
