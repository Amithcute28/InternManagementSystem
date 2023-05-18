<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStudentsController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RecommenderController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\NewStudentsController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\CoordinatorsController;
use App\Http\Controllers\OffCampusController;
use App\Http\Controllers\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//student dashboard
Route::resource('/application', ApplicationController::class);
Route::resource('/status', StatusController::class);
Route::put('/status/update/{studentId}/{institutionId}', [StatusController::class, 'update'])->name('status.update');


//admin dashboard
Route::resource('/admindash', AdminDashboardController::class);
Route::resource('/recommender', RecommenderController::class);
Route::get('/recommendations', [RecommendationController::class, 'index'])
    ->name('recommendations.index');
Route::resource('/schools', SchoolsController::class);
Route::resource('/students', StudentsController::class);
Route::resource('/newstudents', NewStudentsController::class);
Route::resource('/coordinators', CoordinatorsController::class);
Route::resource('/offcampus', OffCampusController::class);

Route::resource('/role', RoleController::class);

Route::put('/recommender/{id}', [RecommenderController::class, 'update'])->name('recommender.update');
Route::put('/newstudents/{id}', [NewStudentsController::class, 'updateApproved'])->name('newstudents.updateApproved');

Route::get('/reports/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $recommendedInstitutions = $student->recommended_institutions()->get(['name', 'required_academic_performance']);
    return view('reports.show', compact('student', 'recommendedInstitutions'));
})->name('reports.show');


Route::get('/dashboard', function () {
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admindash', [AdminDashboardController::class, 'index'])->name('admindash.index');
    Route::put('/recommender/{id}', [RecommenderController::class, 'updateRecommender'])->name('recommender.updateRecommender');
    
});


Route::middleware(['auth'])->group(function () {
    Route::resource('/user', UserStudentsController::class)->middleware('role:user');
    Route::resource('/application', ApplicationController::class);
   

});



require __DIR__.'/auth.php';
