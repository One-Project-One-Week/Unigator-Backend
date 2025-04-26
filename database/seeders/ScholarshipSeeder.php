<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\Scholarship;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ScholarshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        Scholarship::create([
            "program_id" => Program::factory(),
            "type" => $faker->randomElement(['full', 'partial']),
            "scholarship_percentage" => $faker->numberBetween(10, 100),
        ]);
    }
}
