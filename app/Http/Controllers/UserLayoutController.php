<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserLayoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('Student/Main', [
            'users' => $user
        ]);
    }
}
