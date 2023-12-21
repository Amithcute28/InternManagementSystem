<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Addition;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Calendar;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\User;
use App\Models\EmployeeEvaluation;
use App\Models\EmployeePosition;
use App\Models\EmployeeSalary;
use App\Models\EmployeeShift;
use App\Models\Globals;
use App\Models\Manager;
use App\Models\Metric;
use App\Models\Payroll;
use App\Models\Position;
use App\Models\Requests;
use App\Models\Shift;
use App\Services\CommonServices;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeed extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Globals
        $this->seedGlobals();

        // Branches & Departments & Shifts
        $this->seedBranchesDepartmentsPositionsShifts();

        // Create Test Employees
       
    


        // Create roles
      

        // Random Assignments
       
        foreach (User::all() as $index => $employee) {
            if ($employee->id != 1) {
                $employee->assignRole(Role::findByName('user'));
            }

            EmployeeShift::create([
                'employee_id' => $employee->id,
                'shift_id' => $index % 2 + 1,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => null,
            ]);

            $currentDate = CarbonImmutable::now();
            $startDate = $currentDate->startOfMonth();

            $days = $currentDate->diffInDays($startDate);
            $attendanceTypes = ['on_time', 'late', 'missed'];
            $commonServices = new CommonServices();

            // for ($i = 0; $i < $days; $i++) {
            //     if (!$commonServices->isDayOff($startDate->format('Y-m-d'))) {
            //         $activeShift = $employee->activeShift();
            
            //         if ($activeShift) {
            //             Attendance::create([
            //                 'student_id' => $employee->id,
            //                 'date' => $startDate->format('Y-m-d'),
            //                 'status' => 'on_time',
            //                 'sign_in_time' => $activeShift->start_time,
            //                 'sign_off_time' => $activeShift->end_time,
            //             ]);
            //         } else {
            //             Attendance::create([
            //                 'student_id' => $employee->id,
            //                 'date' => $startDate->format('Y-m-d'),
            //                 'status' => 'missed',
            //             ]);
            //         }
            //     }
            //     $startDate = $startDate->addDay();
            // }
        }

        // Assign Managers to branch #1 and department #1
       
        // $this->seedRequests();
        // $this->seedCalendarItems();
    }

        // Generate Random Requests & Calendar Items
        
    

    private function seedGlobals(): void
    {
        Globals::create([
            'organization_name' => 'Global Solutions Inc.',
            'organization_address' => '123 Main Street, Anytown, USA',
            'absence_limit' => 30,
            'email' => 'info@globalsolutions.com',
        ]);
    }
    private function seedBranchesDepartmentsPositionsShifts(): void
    {
        Shift::create([
            'name' => "Day Shift",
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
        ]);

        Shift::create([
            'name' => "Night Shift",
            'start_time' => '16:00:00',
            'end_time' => '00:00:00',
        ]);
    }

    // private function seedRequests(): void
    // {
    //     for ($i = 1; $i <= User::count(); $i++) {
    //         $requestTypes = ['complaint', 'payment', 'leave', 'other'];
    //         Requests::create([
    //             'employee_id' => $i,
    //             'type' => $requestTypes[array_rand($requestTypes)],
    //             'start_date' => Carbon::now()->addDays(fake()->numberBetween(1, 100))->toDateString(),
    //             'end_date' => null,
    //             'message' => fake()->sentence(10),
    //             'status' => fake()->numberBetween(0, 2),
    //             'admin_response' => fake()->sentence(10),
    //             'is_seen' => fake()->boolean,
    //         ]);
    //     }
    // }

    // private function seedCalendarItems(): void
    // {
    //     for ($i = 1; $i <= 10; $i++) {
    //         $calendarTypes = ['holiday', 'meeting', 'event', 'other'];
    //         $start_date = Carbon::now()->addDays(fake()->numberBetween(1, 30));
    //         Calendar::create([
    //             'start_date' => $start_date->toDateString(),
    //             'end_date' => $start_date->addDays(fake()->numberBetween(0, 2))->toDateString(),
    //             'title' => fake()->sentence(2),
    //             'type' => $calendarTypes[array_rand($calendarTypes)],
    //         ]);
    //     }
    // }
    

}