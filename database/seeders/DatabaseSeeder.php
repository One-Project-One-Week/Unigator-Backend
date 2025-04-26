<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Program;
use App\Models\Accomodation;
use App\Models\Rating;
use App\Models\Scholarship;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(30)->create()->each(function ($user) {
            // Each user creates their own university
            $university = University::factory()->create([
                'user_id' => $user->id,
            ]);

            // Programs for their university
            Program::factory(3)->create([
                'university_id' => $university->id,
            ]);

            // Accommodations for their university
            Accomodation::factory(2)->create([
                'university_id' => $university->id,
            ]);

            Scholarship::factory(1)->create([
                'program_id' => Program::inRandomOrder()->first()->uuid,
            ]);

            // Pick a random existing university ID for rating 
            // $randomUniversityId = University::inRandomOrder()->value('uuid');
            // $randomUserId = User::inRandomOrder()->value('id');



        });
    }
}
