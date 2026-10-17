<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Interview;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Interview>
 */
class InterviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'applicant_id' => Applicant::factory(),
            'interviewer' => fake()->name(),
            'interviewed_at' => fake()->dateTimeBetween('-2 months'),
            'communication' => fake()->numberBetween(1, 5),
            'motivation' => fake()->numberBetween(1, 5),
            'vocational_clarity' => fake()->numberBetween(1, 5),
            'comments' => fake()->optional()->sentence(),
        ];
    }
}
