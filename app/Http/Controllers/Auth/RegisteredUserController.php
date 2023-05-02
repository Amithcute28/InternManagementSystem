<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'birthday' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:255',
            
            
            
        ]);

        $user = User::create([
        'student_id' => $request->student_id,
        'password' => Hash::make($request->password),
        'program' => $request->program,
        'year_level' => $request->year_level,
        'full_name' => $request->full_name,
        'email' => $request->email,
        'birthday' => $request->birthday,
        'gender' => $request->gender,
        'relationship' => $request->relationship,
        'nationality' => $request->nationality,
        'contact_number' => $request->contact_number,
        'home_address' => $request->home_address,
        'zip_code' => $request->zip_code,
        'guardian_name' => $request->guardian_name,
        'guardian_contact' => $request->guardian_contact,
        'approved' => 0,

        ])->assignRole('user');
       
        

    

        event(new Registered($user));

Auth::login($user);

if(Auth::check() && Auth::user()->is_admin && $user->approved){
    return redirect()->intended(RouteServiceProvider::HOME);
}

Auth::logout();
return redirect('/login');
    }
}
