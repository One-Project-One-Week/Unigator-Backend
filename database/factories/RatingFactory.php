<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\University;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::inRandomOrder()->value('id'),
            "university_id" => University::inRandomOrder()->value('id'), // 🛠️ fetch random existing university
            "rating_rate" => $this->faker->randomElement([1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]),
        ];
    }
}
