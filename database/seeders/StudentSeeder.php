<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'academic_performance' => 80,
            'program' => 'Computer Science',
            'skills' => 'PHP, JavaScript, HTML, CSS',
        ]);

        Student::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'academic_performance' => 90,
            'program' => 'Information Technology',
            'skills' => 'Java, Python, MySQL, MongoDB',
        ]);

    }
}
