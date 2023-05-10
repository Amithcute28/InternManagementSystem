<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PracticeTeachingOpportunity;

class PracticeTeachingOpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PracticeTeachingOpportunity::create([
            'title' => 'Mathematics Teacher',
            'description' => 'We are looking for a Mathematics teacher to teach grades 9-12.',
            'required_skills' => 'mathematics',
            'subject_area' => 'mathematics',
            'grades' => '9,10,11,12',
        ]);

        PracticeTeachingOpportunity::create([
            'title' => 'English Teacher',
            'description' => 'We are seeking an English teacher for grades 7',
            'required_skills' => 'english',
            'subject_area' => 'english',
            'grades' => '7,8,9',
        ]);
    }
}
