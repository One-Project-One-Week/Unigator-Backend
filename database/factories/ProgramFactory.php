<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\University;
use App\Models\Category;

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
            "category_id" => Category::factory(),
            "name" => $this->faker->word(),
            'detail' => [
                'year' => $this->faker->randomElement(['1st year', '2nd year', '3rd year']),
                'duration' => $this->faker->numberBetween(1, 4),
                'tuition_fees' => $this->faker->numberBetween(1000, 50000),
            ],
            "degree_type" => $this->faker->randomElement(['Bachelor', 'Master', "PhD"]),
            "duration" => $this->faker->numberBetween(1, 4),
            'application_requirement' => [
                'IELTS',
                'Transcript',
            ],
            "intake" => [
                    $this->faker->month(),
                    $this->faker->month()
            ],

            "level" => $this->faker->randomElement(['Undergraduate', 'Postgraduate', 'Doctoral']),
            "payment_plan" => $this->faker->randomElement(['monthly', 'per_semester', 'no_installements']),
            // "average_cost" => 
        ];
    }
}
