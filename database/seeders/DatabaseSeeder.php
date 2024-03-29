<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(AdminSeeder2::class);
        $this->call(StudentSeeder::class);
        $this->call(InstitutionSeeder::class);
        $this->call(DatabaseSeed::class);
        $this->call(StarterSeeder::class);
        
        
       
        

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
