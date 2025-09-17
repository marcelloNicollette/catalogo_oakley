<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->company,
            'contact_name' => fake()->name,
            'email' => fake()->safeEmail,
            'phone' => fake()->phoneNumber,
            'status' => fake()->randomElement(['new', 'contacted', 'won', 'lost']),
        ];
    }
}
