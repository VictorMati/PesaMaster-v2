<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'type' => $this->faker->randomElement(['deposit', 'withdrawal', 'payment']),
            'transaction_date' => now(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'description' => $this->faker->sentence,
            'payment_method' => $this->faker->randomElement(['cash', 'mpesa', 'bank'])
        ];
    }
}
