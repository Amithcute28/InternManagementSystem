<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'student_id'=> '1',
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'full_name'=> 'John Rey A. Amith',
            'academic_performance' => 80,
            'program' => 'BEED',
            'skills' => 'PHP, JavaScript, HTML, CSS',
            'email'=> 'admin@gmail.com',
            'email_verified_at' => now(),
            'birthday'=> 'October 28, 2000',
            'gender'=> 'Male',
            'relationship'=> 'Single',
            'nationality'=> 'Filipino',
            'contact_number'=> '09691277480',
            'guardian_name'=> 'Ian Ben',
            'guardian_contact'=> '123456789',
            'remember_token' => Str::random(10),
            'is_admin' => 1,
            'approved' => 1,
        ])->assignRole('admin');

        
    }
}
