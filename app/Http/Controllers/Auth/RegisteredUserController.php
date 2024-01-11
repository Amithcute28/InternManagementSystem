<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Student;
use App\Models\TemporaryRegistration;
use App\Notifications\VerifyEmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\EmployeeShift;
use Spatie\Permission\Models\Role;

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
    public function store(RegisterRequest $request): RedirectResponse
    {

        $user = User::create([
            'student_id' => $request->student_id,
            'program' => $request->program,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => 0,
            'recommended' => 0,


        ])->assignRole('user');

      

            EmployeeShift::create([
                'employee_id' => $user->id,
                'shift_id' => 1,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => null,
            ]);

           
        
        

        $user->sendEmailVerificationNotification();


        Auth::login($user);



        return redirect()->route('verification.notice');
    }
}

