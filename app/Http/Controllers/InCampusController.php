<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Models\ApplicationForm;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InCampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qualifiedUsers = User::where('approved', 1)->where('is_admin', 0)
            ->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])
            ->where('in_campus', 0)
            ->where('applications', 1)
            ->where('is_off_campus', 0)
            ->with(['applicationForms' => function ($query) {
                $query->select('user_id', 'eval_form', 'eslip', 'psa', 'pros', 'applicationF', 'medical', 'parent', 'twobytwo', 'created_at');
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
                    'in_campus' => $user->in_campus,
                    'eval_form' => $applicationForm ? ($applicationForm->eval_form ? asset('storage/student/' . $applicationForm->eval_form) : null) : null,
                    'eslip' => $applicationForm ? ($applicationForm->eslip ? asset('storage/student/' . $applicationForm->eslip) : null) : null,
                    'psa' => $applicationForm ? ($applicationForm->psa ? asset('storage/student/' . $applicationForm->psa) : null) : null,
                    'pros' => $applicationForm ? ($applicationForm->pros ? asset('storage/student/' . $applicationForm->pros) : null) : null,
                    'applicationF' => $applicationForm ? ($applicationForm->applicationF ? asset('storage/student/' . $applicationForm->applicationF) : null) : null,
                    'medical' => $applicationForm ? ($applicationForm->medical ? asset('storage/student/' . $applicationForm->medical) : null) : null,
                    'parent' => $applicationForm ? ($applicationForm->parent ? asset('storage/student/' . $applicationForm->parent) : null) : null,
                    'twobytwo' => $applicationForm ? ($applicationForm->twobytwo ? asset('storage/student/' . $applicationForm->twobytwo) : null) : null,
                    'created_at' => $applicationForm ? $applicationForm->created_at->format('d-m-y H:i:s') : null,
                ];
            });

        $perPage = request()->input('perPage') ?: 5;
        $filteredData = $qualifiedUsers->when(request()->input('search'), function ($collection, $search) {
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

        $filtered_files = collect(Storage::allFiles())->filter(function ($value, $key) {
            $allowed_extensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), $allowed_extensions);
        })->values();

        $interns = User::where('approved', 1)->where('is_admin', 0)->where('in_campus', 0)->where('applications', 1)->where('is_off_campus', 0)->whereIn('program', ['BEED', 'BECEd', 'BSNEd', 'BPEd'])->get();
        $totalInterns = $interns->count();

        return Inertia::render('Admin/Pages/InCampus', [
            'files' => $filtered_files,
            'offCampus' => $paginateData,
            'filters' => request()->only(['search', 'perPage']),
            'interns' => $interns,
            'totalInterns' => $totalInterns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

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
