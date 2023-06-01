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

class NewStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // return Inertia::render('Admin/Pages/NewStudents',[
        //     'newstudents' => UserResource::collection(User::where('approved', '=', 0)->get()),
            
        $newstudentsbeed = User::where('approved', '=', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalNewStudents = $newstudentsbeed->count();

            $newstudents = User::where('approved', '=', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->paginate(8);
           
            
            

            return Inertia::render('Admin/Pages/NewStudents',[
                'newstudents' => UserResource::collection($newstudents),
                'newstudentsbeed' => UserResource::collection($newstudentsbeed),
                'totalNewStudents' => $totalNewStudents,
            ]);

          
        
    }

    public function edit(User $newstudent): Response
    {
        return Inertia::render('Admin/Pages/NewStudentsApproval', [
            'newstudent' => $newstudent,
        ]);
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

        $newstudent->update([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'approved' => 1,
        ]);

        return to_route('newstudents.index');
    }

    public function updateApproved($id)
    {
        $newstudent = User::find($id);
        
      
            $newstudent->approved = 1;
            $newstudent->save();
        
        
        // Add any additional logic or response handling as needed
        
        return redirect()->route('newstudents.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $newstudent): RedirectResponse
    {
        $newstudent->delete();
        return to_route('newstudents.index');
    }
}
