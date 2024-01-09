<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentCalendarController;
use App\Http\Controllers\STEController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserStudentsController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RecommenderController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\NewStudentsController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\SchoolsDeleteController;
use App\Http\Controllers\CoordinatorsController;
use App\Http\Controllers\OffCampusController;
use App\Http\Controllers\InCampusController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//adminBSED*/
use App\Http\Controllers\ApplicationControllerBSED;
use App\Http\Controllers\AdminDashboardControllerBSED;
use App\Http\Controllers\StudentsControllerBSED;
use App\Http\Controllers\NewStudentsControllerBSED;
use App\Http\Controllers\SchoolsControllerBSED;
use App\Http\Controllers\OffCampusControllerBSED;
use App\Http\Controllers\CoordinatorsControllerBSED;
use App\Models\Student;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Auth;

//admin dashboard BSED
Route::resource('/admindashbsed', AdminDashboardControllerBSED::class);
Route::resource('/schoolsbsed', SchoolsControllerBSED::class);
Route::resource('/studentsbsed', StudentsControllerBSED::class);
Route::resource('/newstudentsbsed', NewStudentsControllerBSED::class);
Route::resource('/coordinatorsbsed', CoordinatorsControllerBSED::class);
Route::resource('/offcampusbsed', OffCampusControllerBSED::class);
Route::resource('/applicationbsed', ApplicationControllerBSED::class);

Route::put('/newstudentsbsed/{id}', [NewStudentsControllerBSED::class, 'updateApproved'])->name('newstudentsbsed.updateApproved');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admindashbsed', [AdminDashboardControllerBSED::class, 'index'])->name('admindashbsed.index');
    Route::get('in-campusbsed', [StudentsControllerBSED::class, 'inCampus'])->name('studentsbsed.inCampus');
    Route::get('off-campusbsed', [StudentsControllerBSED::class, 'offCampus'])->name('studentsbsed.offCampus');
    Route::get('in-campus-applicationbsed', [ApplicationControllerBSED::class, 'inCampusApplication'])->name('applicationsbsed.inCampusApplication');
    Route::get('off-campus-applicationbsed', [ApplicationControllerBSED::class, 'offCampusApplication'])->name('applicationsbsed.offCampusApplication');
    Route::put('off-campus-applicationbsed/{id}', [ApplicationControllerBSED::class, 'updateStatus'])->name('applicationsbsed.updateStatus');
});
Route::put('/applicationsUpdatebsed/{id}', [ApplicationControllerBSED::class, 'updateIncampus'])->name('applicationsbsed.updateIncampus');
Route::get('in-campus-application-editbsed', [ApplicationControllerBSED::class, 'edit'])->name('applicationsbsed.edit');
Route::DELETE('in-campus-application-destroybsed', [ApplicationControllerBSED::class, 'destroy'])->name('applicationsbsed.destroy');
Route::put('/updatenewstudent/{id}', [NewStudentsControllerBSED::class, 'updateNewStudent'])->name('newstudentsbsed.updateNewStudent');
Route::put('/applicationsbsed/{id}', [ApplicationControllerBSED::class, 'updateOffcampus'])->name('applicationsbsed.updateOffcampus');
Route::delete('/studentsbsed/{id}', [StudentsControllerBSED::class, 'destroy'])->name('studentsbsed.destroy');
Route::delete('/newstudentsbsed/{id}', [NewStudentsControllerBSED::class, 'destroy'])->name('newstudentsbsed.destroy');
Route::put('/studentsbsed/{id}', [studentsControllerBSED::class, 'update'])->name('adminProfile.update');
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

Route::resource('/student-calendar', StudentCalendarController::class);
Route::get('/calendar-items', [CalendarController::class, 'calendarIndex'])->name('calendar.calendarIndex');
Route::get('/calendar-items-ste', [StudentCalendarController::class, 'indexSte'])->name('calendar.calendarSte');
Route::put('/status/update/{studentId}/{institutionId}', [StatusController::class, 'update'])->name('status.update');
Route::get('/my-attendance', [AttendanceController::class, 'attendanceDashboard'])->middleware('auth')->name('attendance.dashboard');
Route::resource('/attendance', AttendanceController::class);
Route::resource('/requests', RequestController::class)->only(['index', 'show', 'create', 'store', 'destroy']);
Route::resource('/calendar', CalendarController::class);
Route::get('/requests-admin', [RequestController::class, 'adminRequestsIndex'])->name('requests-admin.requestsIndex');
Route::put('/requests-update/{id}', [RequestController::class, 'update'])->name('requests-update.update');
Route::get('/request-show-student/{id}', [RequestController::class, 'showStudent'])->name('requests-show-student.show');

Route::post('attendance/signin', [AttendanceController::class, 'dashboardSignInAttendance'])->name('attendance.dashboardSignIn');
Route::post('attendance/signoff', [AttendanceController::class, 'dashboardSignOffAttendance'])->name('attendance.dashboardSignOff');


//admin dashboard BEED
Route::resource('/admindash', AdminDashboardController::class);
Route::resource('/recommender', RecommenderController::class);

Route::resource('/students', StudentsController::class);
Route::resource('/newstudents', NewStudentsController::class);
Route::resource('/coordinators', CoordinatorsController::class);

Route::resource('/offcampus', OffCampusController::class);
Route::get('/offcampus-attendance/{id}', [OffCampusController::class, 'attendanceStudent'])->name('offcampus-attendance.attendanceStudent');

Route::resource('schools', SchoolsController::class);
Route::resource('adminProfile', AdminProfileController::class);
Route::put('/adminProfile/{id}', [AdminProfileController::class, 'update'])->name('adminProfile.update');
Route::delete('/schools/{id}', [SchoolsController::class, 'destroy'])->name('schools.destroy');
Route::delete('/schools/{id}', [SchoolsController::class, 'show'])->name('schools.show');
Route::delete('/coordinators/{id}', [CoordinatorsController::class, 'destroy'])->name('coordinators.destroy');
Route::get('/schools/{id}', [SchoolsController::class, 'edit'])->name('schools.edit');
Route::resource('/role', RoleController::class);

Route::put('/recommender/{id}', [RecommenderController::class, 'update'])->name('recommender.update');
Route::put('/newstudentsupdateApprove/{id}', [NewStudentsController::class, 'updateApproved'])->name('newstudents.updateApproved');
Route::put('/applications/{id}', [ApplicationController::class, 'updateOffcampus'])->name('applications.updateOffcampus');
Route::put('/applicationsUpdate/{id}', [ApplicationController::class, 'updateIncampus'])->name('applications.updateIncampus');
Route::put('/applicationsUpdateDone/{id}', [ApplicationController::class, 'updateIncampusDone'])->name('applications.updateIncampusDone');

Route::put('/schools/{id}', [SchoolsController::class, 'edit'])->name('schools.edit');
Route::delete('/schools/{id}', [SchoolsController::class, 'destroy'])->name('schools.destroy');
Route::put('/schools/{id}', [SchoolsController::class, 'update'])->name('schools.update');
Route::get('/schools/{id}', [SchoolsController::class, 'edit'])->name('schools.edit');


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
    Route::get('in-campus', [StudentsController::class, 'inCampus'])->name('students.inCampus');
    Route::get('off-campus', [StudentsController::class, 'offCampus'])->name('students.offCampus');
    Route::get('in-campus-application', [ApplicationController::class, 'inCampusApplication'])->name('applications.inCampusApplication');
    Route::get('off-campus-application', [ApplicationController::class, 'offCampusApplication'])->name('applications.offCampusApplication');
    Route::put('off-campus-application/{id}', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('in-campus-application-edit', [ApplicationController::class, 'edit'])->name('applications.edit');
    Route::DELETE('in-campus-application-destroy', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    Route::delete('in-campus-application/{id}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

    Route::get('attendances/{date}', [AttendanceController::class, 'dayShow'])->name('attendances.show');
    Route::delete('attendance', [AttendanceController::class, 'dayDelete'])->name('attendance.destroy');
    Route::get('/attendance-list', [AttendanceController::class, 'attendanceList'])->name('attendance-list.attendanceList');

    Route::resource('/first-shift', InCampusController::class);
    Route::put('/first-shift-update/{id}', [InCampusController::class, 'updateEval'])->name('first-shift.updateEval');
});


Route::resource('/ste-dashboard', SteController::class);
Route::get('/admin-stes', [SteController::class, 'adminStes'])->name('admin-stes.adminStes');
Route::get('/ste-interns', [SteController::class, 'interns'])->name('stes-interns.interns');
Route::get('/ste-attendance', [SteController::class, 'attendanceSte'])->name('ste-attendance.attendanceSte');
Route::get('ste-attendances/{date}', [SteController::class, 'dayShow'])->name('ste-attendances.show');
Route::post('/ste-store', [SteController::class, 'storeSte'])->name('ste-store.storeSte');
Route::delete('ste', [SteController::class, 'dayDelete'])->name('ste.destroy');
Route::put('/ste-interns-proceed/{id}', [SteController::class, 'proceed'])->name('stes-interns.proceed');
Route::put('/ste-dashboard/{id}', [SchoolsController::class, 'update'])->name('ste-dashboard.update');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/user', UserStudentsController::class)->middleware('role:user');
    Route::resource('/application', ApplicationController::class)->middleware(HandlePrecognitiveRequests::class);
    Route::get('/application/{id}', [ApplicationController::class, 'editInternApplication'])->name('applications.editInternApplication');
    Route::put('/application', [ApplicationController::class, 'updateInternApplication'])->name('applications.updateInternApplication')->middleware(HandlePrecognitiveRequests::class);
    Route::delete('/application/delete/{id}', [ApplicationController::class, 'deleteInternApplication'])->name('applications.deleteInternApplication');
    Route::post('/user', [UserStudentsController::class, 'showProfile'])->name('user.showProfile');



    Route::get('/cities/{province}', [UserStudentsController::class, 'getCities']);
    Route::get('/zipcodes/{province}/{city}', [UserStudentsController::class, 'getZipcode']);
    Route::get('/getProvinceAndCity/{zipCode}', [UserStudentsController::class, 'getProvinceAndCity']);
});

Route::post('/user', [UserStudentsController::class, 'updateNewIntern'])->name('user.updateNewIntern');

Route::get('/register/verify/{token}', [RegisteredUserController::class, 'verify'])->name('verification.verify');


require __DIR__ . '/auth.php';
