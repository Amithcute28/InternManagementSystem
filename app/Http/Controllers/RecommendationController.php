<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Institution;
use Inertia\Inertia;
class RecommendationController extends Controller
{
    public function recommend($studentId)
    {
        // Retrieve the student record from the database
        $student = Student::findOrFail($studentId);

        // Retrieve all institutions that require the student's subject
        $institutions = Institution::where('required_subject', $student->subject)->get();

        // Filter the institutions based on the student's GPA
        $eligibleInstitutions = $institutions->filter(function ($institution) use ($student) {
            return $student->gpa >= $institution->required_gpa;
        });

        // Sort the eligible institutions by location
        $sortedInstitutions = $eligibleInstitutions->sortBy('location');

        // Render the "recommend" view with the sorted institutions
        return Inertia::render('Recommend', [
            'student' => $student,
            'institutions' => $sortedInstitutions,
        ]);
    }
}
