<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\EmployeeSalary;
use App\Models\EmployeeShift;
use App\Models\Globals;
use App\Models\Manager;
use App\Models\Position;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class StarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Globals::create([
        //     'organization_name' => 'Global Solutions Inc.',
        //     'organization_address' => '123 Main Street, Anytown, USA',
        //     'absence_limit' => 30,
        //     'email' => 'info@globalsolutions.com',
        // ]);

      

     
        // Shift::create([
        //     'name' => "Day Shift",
        //     'start_time' => '08:00:00',
        //     'end_time' => '16:00:00',
        // ]);


       
        // EmployeeShift::create([
        //     'employee_id' => 1,
        //     'shift_id' => 1,
        //     'start_date' => now()->format('Y-m-d'),
        //     'end_date' => null,
        // ]);
    }
}
