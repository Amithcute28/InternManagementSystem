<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\StudentsResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\ProfileUpdateRequest;

class NewStudentsControllerBSED extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // return Inertia::render('Admin/Pages/NewStudents',[
        //     'newstudents' => UserResource::collection(User::where('approved', '=', 0)->get()),

        $newstudentsbsed = User::where('approved', '=', 0)->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])->get();
        $totalNewStudents = $newstudentsbsed->count();

        


        $perPage = request()->input('perPage') ?: 5;
        return Inertia::render('Admin/PagesBSED/NewStudents', [
            'newstudents' => User::query()
            ->when(request()->input('search'), function($query, $search) {
                $query->where(function($subquery) use ($search) {
                    $subquery->where('student_id', 'like', "%{$search}%")
                            ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->where('approved', '=', 0)
            ->whereIn('program', ['BSED', 'BSED English', 'BSED Filipino', 'BSED Mathematics', 'BSED Science', 'BSED Social Studies'])
            ->paginate($perPage)
            ->withQueryString(),
            'filters' => request()->only(['search', 'perPage']),
            'newstudentsbsed' => UserResource::collection($newstudentsbsed),
            'totalNewStudents' => $totalNewStudents,
        ]);
    }

    // public function edit($newstudentbsed): Response
    // {
    //     $newstudentbsed = User::findOrFail($newstudentbsed);
    //     return Inertia::render('Admin/PagesBSED/NewStudentsApproval', [
    //         'newstudentbsed' => $newstudentbsed,
    //     ]);
    // }   

    public function edit($id): Response
    {
        $newstudentbsed = User::find($id);
        return Inertia::render('Admin/PagesBSED/NewStudentsApproval', [
            'newstudentbsed' => $newstudentbsed,
        ]);
    }

    public function updateNewStudent($id)
    {
        $student = User::find($id);


        $student->approved = 1;
        $student->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('newstudentsbsed.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
    }



    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $newstudent): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255|' . Rule::unique('users', 'student_id')->ignore($newstudent),
            'program' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($newstudent),



        ]);

        $newstudent = Auth::user();
        $newstudent->update([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'approved' => 1,
        ]);

        return to_route('newstudentsbsed.index');
    }

    public function updateApproved($id)
    {
        $newstudent = User::find($id);


        $newstudent->approved = 1;
        $newstudent->save();


        // Add any additional logic or response handling as needed

        return redirect()->route('newstudentsbsed.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $newstudent = User::find($id);
        $newstudent->delete();
        return to_route('newstudentsbsed.index');
    }
}
