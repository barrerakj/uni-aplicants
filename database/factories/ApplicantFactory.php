<?php

namespace Database\Factories;

use App\Enums\ApplicantStatus;
use App\Enums\Program;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'previous_school' => fake()->company().' High School',
            'program' => fake()->randomElement(Program::cases()),
            'status' => ApplicantStatus::Pending,
        ];
    }
}
