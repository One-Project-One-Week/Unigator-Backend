<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\University>
 */
class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::factory(),
            "description" => $this->faker->text(200),
            "country" => $this->faker->country(),
            "city" => $this->faker->city(),
            "address" => $this->faker->address(),
            "ranking" => $this->faker->numberBetween(1, 100),
            "logo" => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'),
            "slug" => $this->faker->slug(),
        ];
    }
}
