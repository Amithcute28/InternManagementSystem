<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTeaching;
use Illuminate\Support\Facades\Hash;

class UserTeachingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserTeaching::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Math',
            'grade' => 9,
            'school_level' => 'High School',
            'school_subjects' => json_encode([
                'Math',
                'Science',
                'English',
            ]),
            'school_skills' => json_encode([
                'Communication',
                'Critical Thinking',
                'Problem Solving',
            ]),
        ]);
        UserTeaching::create([
            'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'subject' => 'Science',
                'grade' => 7,
                'school_level' => 'Elementary School',
                'school_subjects' => json_encode([
                    'Science',
                    'Math',
                    'English',
                ]),
                'school_skills' => json_encode([
                    'Communication',
                    'Collaboration',
                    'Creative Thinking',
                ]),
        ]);
        UserTeaching::create([
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'subject' => 'English',
            'grade' => 10,
            'school_level' => 'High School',
            'school_subjects' => json_encode([
                'English',
                'Social Studies',
                'Math',
            ]),
            'school_skills' => json_encode([
                'Problem Solving',
                'Collaboration',
                'Critical Thinking',
            ]),
        ]);
    }
}
