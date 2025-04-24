<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\University;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
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
            "name" => $this->faker->word(),
            'detail' => [
                'description' => $this->faker->sentence(8),
                'level' => $this->faker->randomElement(['Undergraduate', 'Postgraduate']),
                'duration' => $this->faker->numberBetween(1, 4),
                'tuition_fees' => $this->faker->numberBetween(1000, 50000),
            ],
            "degree_type" => $this->faker->randomElement(['Bachelor', 'Master']),
            "duration" => $this->faker->numberBetween(1, 4),
            'application_requirement' => [
                'IELTS',
                'Transcript',
            ],
            "intake" => $this->faker->date(),
            "payment_plan" => $this->faker->randomElement(['monthly', 'per_semester', 'no_installements']),

        ];
    }
}
