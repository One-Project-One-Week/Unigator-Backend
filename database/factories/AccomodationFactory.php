<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\University;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accomodation>
 */
class AccomodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "university_id" => University::factory(),
            "estimated_cost" => $this->faker->numberBetween(100, 1000),
            "type" =>$this->faker->randomElement(['dorm', 'private-rental']),
        ];
    }
}
