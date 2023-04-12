<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

class AdminController extends Controller
{
    //
    public function index(): Response
    {
        return Inertia::render('Admin/AdminDashboard');
    }
}
