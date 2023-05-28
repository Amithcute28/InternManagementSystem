<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Http\Resources\UserResource;
use App\Http\Resources\StudentsResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;   
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Models\Institution;

class CoordinatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
    
    // return Inertia::render('Admin/Pages/Coordinators', [
    //     'coordinators' => UserResource::collection(User::where('is_admin', 1)->get()),
        
    // ]);

    $students = User::all();

        return Inertia::render('Admin/Pages/Coordinators', [
            'students' => $students
        ]);
          
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function show()
    {
        return view('profile');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old profile image if exists
        if ($user->profile_image) {
            $this->deleteProfileImage($user->profile_image);
        }

        // Upload new profile image
        $imagePath = $request->file('profile_image')->store('profile_images');

        // Update user's profile image column
        $user->profile_image = $imagePath;
        $user->save();

        return redirect()->back()->with('success', 'Profile image uploaded successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old profile image if exists
        if ($user->profile_image) {
            $this->deleteProfileImage($user->profile_image);
        }

        // Upload new profile image
        $imagePath = $request->file('profile_image')->store('profile_images');

        // Update user's profile image column
        $user->profile_image = $imagePath;
        $user->save();

        return redirect()->back()->with('success', 'Profile image updated successfully.');
    }

    public function delete()
    {
        $user = Auth::user();

        // Delete profile image if exists
        if ($user->profile_image) {
            $this->deleteProfileImage($user->profile_image);
            $user->profile_image = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile image deleted successfully.');
    }

    private function deleteProfileImage($imagePath)
    {
        // Delete the profile image file from storage
        Storage::delete($imagePath);
    }
}