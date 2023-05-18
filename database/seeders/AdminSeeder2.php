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
    public function run(): void
    {
        //
        User::create([
            'student_id'=> '2',
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'program'=> 'BSIT',
            'year_level'=> 'Fourth year',
            'full_name'=> 'Arvin G. Felicen',
            'academic_performance' => 90,
            'program' => 'Information Technology',
            'skills' => 'Java, Python, MySQL, MongoDB',
            'email'=> 'admin2@gmail.com',
            'email_verified_at' => now(),
            'birthday'=> 'October 28, 2000',
            'gender'=> 'Male',
            'relationship'=> 'Single',
            'nationality'=> 'Filipino',
            'contact_number'=> '09691277480',
            'home_address'=> 'Tacloban City',
            'zip_code'=> '6810',
            'guardian_name'=> 'Ian Ben',
            'guardian_contact'=> '123456789',
            'remember_token' => Str::random(10),
        ])->assignRole('user');

    
    }
}
