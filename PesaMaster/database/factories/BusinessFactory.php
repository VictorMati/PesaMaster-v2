<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_name' => $this->faker->company,
            'owner_id' => \App\Models\User::factory(), // Assumes the owner is a user
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'business_type' => $this->faker->randomElement(['retail', 'wholesale', 'manufacturing']),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
