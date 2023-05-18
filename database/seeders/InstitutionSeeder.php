<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;
class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institution::create([
            'name' => 'ABC University',
            'address' => '123 Main St, Anytown, USA',
            'requirements' => 'High School Diploma or equivalent',
            'academic_performance' => 85,
            'required_programs' => 'Computer Science, Information Technology',
            'skills' => 'PHP, Java, Python, JavaScript',
        ]);

        Institution::create([
            'name' => 'XYZ College',
            'address' => '456 Oak St, Anytown, USA',
            'requirements' => 'High School Diploma or equivalent',
            'academic_performance' => 90,
            'required_programs' => 'Information Technology, Web Development',
            'skills' => 'JavaScript, HTML, CSS, React, Node.js',
        ]);
    }
}
