<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Institution;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class OffCampusController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $students = User::where('is_off_campus', '=', 1)
            ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
            ->where('approved', '=', 1)
            ->where('is_admin', '=', 0)
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo');
            }])
            ->get()
            ->map(function ($user) {
                $applicationForm = $user->applicationForms->first(); // Get the first application form

                return [
                    'id' => $user->id,
                    'student_id' => $user->student_id,
                    'email' => $user->email,
                    'profile' => $user->profile,
                    'full_name' => $user->full_name,
                    'program' => $user->program,
                    'skills' => $user->skills,
                    'in_campus' => $user->in_campus,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                ];
            });

        $students->each(function ($student) {
            $matchingInstitutions = School::where('required_programs', 'LIKE', "%{$student['program']}%")
                ->where(function ($query) use ($student) {
                    $query->whereIn('skills', explode(',', $student['skills']));
                })
                ->get()
                ->map(function ($institution) {
                    return [
                        'id' => $institution->id,
                        'name' => $institution->name,
                        'address' => $institution->address,
                        'school_logo' => asset('storage/student/' . $institution->school_logo),
                        'required_programs' => $institution->required_programs,
                        'required_academic_performance' => $institution->required_academic_performance,
                        'skills' => $institution->skills,
                    ];
                });

            $requiredProgramsMatch = School::where('required_programs', 'LIKE', "%{$student['program']}%")
                ->whereNotIn('id', $matchingInstitutions->pluck('id'))
                ->get()
                ->map(function ($institution) {
                    return [
                        'id' => $institution->id,
                        'name' => $institution->name,
                        'address' => $institution->address,
                        'school_logo' => asset('storage/' . $institution->school_logo),
                        'required_programs' => $institution->required_programs,
                        'required_academic_performance' => $institution->required_academic_performance,
                        'skills' => $institution->skills,
                    ];
                });

            $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);

            $student['recommended_institutions'] = $recommendedInstitutions;
        });

        $perPage = request()->input('perPage') ?: 5;
        $filteredData = $students->when(request()->input('search'), function ($collection, $search) {
            return $collection->filter(function ($item) use ($search) {
                return stripos($item['student_id'], $search) !== false || stripos($item['full_name'], $search) !== false;
            });
        });

        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredData->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), $perPage),
            $filteredData->count(),
            $perPage,
            null,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $paginateData = $paginatedData->appends(request()->query());

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('is_off_campus', 1)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();


        return Inertia::render('Admin/Pages/OffCampus', [
            'students' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,
        ]);
    }

    public function attendanceStudent(Request $request, string $id)
    {
        $request->validate([
            'term' => 'nullable|date_format:Y-m-d',
        ]);

        $user = User::findOrFail($id); // Get the logged-in user

        $dateParam = $request->input('term', '');

        if ($dateParam) {
            $date = Carbon::createFromFormat('Y-m-d', $dateParam)->startOfDay();
            if ($date->isAfter(Carbon::today())) {
                return response()->json(['Error' => 'Date cannot be in the future. Go back and choose a date before today.']);
            }

            $date = $date->toDateString();
        } else {
            $date = '';
        }

        $attendanceList = Attendance::select(
            'date',
            'status',
            'sign_in_time',
            'sign_off_time',
            'notes',
            DB::raw('COUNT(CASE WHEN status IN (\'late\', \'on_time\') THEN 1 END) as attended_count'),
            DB::raw('COUNT(CASE WHEN status = \'on_time\' THEN 1 END) as on_time_count'),
            DB::raw('COUNT(CASE WHEN status = \'late\' THEN 1 END) as late_count'),
            DB::raw(
                'COUNT(CASE WHEN status = \'missed\' THEN 1 END) as missed_count'
            )
        )
            ->with('user') // Eager load the User model relationship
            ->where('student_id', $user->id) // Filter by the logged-in user's ID
            ->groupBy('date', 'status', 'sign_in_time', 'sign_off_time', 'notes')
            ->orderByDesc('date');

        if ($date) {
            $attendanceList->where('date', '=', $date);
        }

        return Inertia::render('Admin/Pages/AttendanceStudent', [
            "attendanceList" => $attendanceList->get(), // Use get to retrieve the results
            "dateParam" => $date,
            "EmployeeStats" => $user->myInfo(),
        ]);
    }


    /**
     * Recommend institutions for a student.
     */
    //     public function show(string $id)
    // {
    //     $student = Student::findOrFail($id);

    //     $institutions = Institution::where('required_programs', 'LIKE', "%{$student->program}%")->get();

    //     $recommendedInstitutions = [];

    //     foreach ($institutions as $institution) {
    //         if ($student->academic_performance >= $institution->required_academic_performance) {
    //             $recommendedInstitutions[] = $institution;
    //         }
    //     }

    //     $student->recommended_institutions = $recommendedInstitutions;

    //     if (count($recommendedInstitutions) > 0) {
    //         return Inertia::render('Admin/Pages/RecommendInstitution', [
    //             'student' => $student,
    //         ]);
    //     } else {
    //         return Inertia::render('Admin/Pages/WaitingToRecommend', [
    //             'student' => $student,
    //         ]);
    //     }
    // }

    public function show(string $id)
    {

        $student = User::findOrFail($id);

        // Get institutions that match the user's program and skills
        $matchingInstitutions = School::where('required_programs', 'LIKE', "%{$student->program}%")
            ->where(function ($query) use ($student) {
                $query->where(function ($innerQuery) use ($student) {
                    $innerQuery->whereIn('skills', explode(',', $student->skills));
                });
            })
            ->get()
            ->map(function ($institution) {
                return [
                    'id' => $institution->id,
                    'name' => $institution->name,
                    'address' => $institution->address,
                    'school_logo' => asset('storage/' . $institution->school_logo),
                    'required_programs' => $institution->required_programs,
                    'required_academic_performance' => $institution->required_academic_performance,
                    'skills' => $institution->skills,
                ];
            });

        // Get institutions that match the required_programs of the user
        $requiredProgramsMatch = School::where('required_programs', 'LIKE', "%{$student->program}%")
            ->whereNotIn('id', $matchingInstitutions->pluck('id')) // Exclude institutions already matched by program and skills
            ->get()
            ->map(function ($institution) {
                return [
                    'id' => $institution->id,
                    'name' => $institution->name,
                    'address' => $institution->address,
                    'school_logo' => asset('storage/' . $institution->school_logo),
                    'required_programs' => $institution->required_programs,
                    'required_academic_performance' => $institution->required_academic_performance,
                    'skills' => $institution->skills,
                ];
            });

        $recommendedInstitutions = $matchingInstitutions->concat($requiredProgramsMatch);

        $student->recommended_institutions = $recommendedInstitutions;



        if ($student->choosen_institution != 0) {
            $institution = School::findOrFail($student->choosen_institution);
            $institution->school_logo = asset('storage/' . $institution->school_logo);
            return Inertia::render('Admin/Pages/ViewOffCampus', [
                'student' => $student,
                'institution' => $institution,
            ]);
        } else {
            return Inertia::render('Admin/Pages/WaitingOffCampus', [
                'student' => $student,
            ]);
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
