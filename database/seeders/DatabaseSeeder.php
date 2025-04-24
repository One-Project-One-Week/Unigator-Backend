<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Program;
use App\Models\Accomodation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(10)->create()->each(function ($user)
        {
            $university = University::factory()->create([
                'user_id' => $user->id,
            ]);
    
            Program::factory(3)->create([
                'university_id' => $university->id,
            ]);
    
            Accomodation::factory(2)->create([
                'university_id' => $university->id,
            ]);
        });
    }
}
