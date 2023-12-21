<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'student_id'  => '2',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'full_name'  => 'Arvin G. Felicen',
            'academic_performance' => 90,
            'program' => 'BSED',
            'skills' => 'Java, Python, MySQL, MongoDB',
            'email' => 'admin2@gmail.com',
            'email_verified_at' => now(),
            'birthday' => 'October 28, 2000',
            'gender' => 'Male',
            'relationship' => 'Single',
            'nationality' => 'Filipino',
            'contact_number' => '09691277480',
            // 'home_address' => 'Tacloban City',
            'guardian_name' => 'Ian Ben',
            'guardian_contact' => '123456789',
            'remember_token' => Str::random(10),
            'is_admin' => 1,
            'approved' => 1,
        ])->assignRole('admin');
        
    }
}

