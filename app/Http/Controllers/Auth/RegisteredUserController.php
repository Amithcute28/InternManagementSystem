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
            'program' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
           
            
            
            
            
        ]);

        $user = User::create([
        'student_id' => $request->student_id,
        'program'=> $request->program,
        'full_name' => $request->full_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'approved' => 0,
        'recommended' => 0,


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
