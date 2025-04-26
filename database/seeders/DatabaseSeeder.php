<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Program;
use App\Models\Accomodation;
use App\Models\Rating;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(30)->create()->each(function ($user) {

            $university = University::factory()->create([
                'user_id' => $user->id,
            ]);

            Program::factory(3)->create([
                'university_id' => $university->id,
            ]);

            Accomodation::factory(2)->create([
                'university_id' => $university->id,
            ]);

            $randomUniversityId = University::inRandomOrder()->value('id');
            $randomUserId = User::inRandomOrder()->value('id');

            Rating::factory()->create([
                'user_id' => $randomUserId,
                'university_id' => $randomUniversityId,
            ]);
        });
    }
}
