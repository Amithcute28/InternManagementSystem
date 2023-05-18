<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeachingPractice;

class TeachingPracticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeachingPractice::create([
            'name' => 'Fun Math Activities',
            'description' => 'A collection of fun math activities for students in grades 1-3',
            'subject' => 'Math',
            'grade' => 1,
            'school_level' => 'Elementary',
            'school_subjects' => json_encode(['Math']),
            'school_skills' => json_encode(['Problem Solving', 'Critical Thinking']),
        ]);
        TeachingPractice::create([
            'name' => 'Science Experiments at Home',
            'description' => 'A series of science experiments that can be done at home with minimal equipment',
            'subject' => 'Science',
            'grade' => 4,
            'school_level' => 'Elementary',
            'school_subjects' => json_encode(['Science']),
            'school_skills' => json_encode(['Experimental Design', 'Data Analysis']),
        ]);
        TeachingPractice::create([
            'name' => 'English Writing Prompts',
            'description' => 'A set of writing prompts to help students improve their English writing skills',
            'subject' => 'English',
            'grade' => 9,
            'school_level' => 'High School',
            'school_subjects' => json_encode(['English']),
            'school_skills' => json_encode(['Writing', 'Research']),
        ]);
    }
}
