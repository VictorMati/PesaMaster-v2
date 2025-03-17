<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MpesaTransaction>
 */
class MpesaTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Str::uuid(), // Generates a unique identifier
            'user_id' => User::factory(), // Links to a randomly created user
            'phone_number' => $this->faker->numerify('2547########'),
            'amount' => $this->faker->randomFloat(2, 50, 10000), // Amount between 50 and 10000
            'status' => $this->faker->randomElement(['Success', 'Pending', 'Failed']),
            'receipt_number' => strtoupper($this->faker->bothify('??????#####')), // Random MPESA receipt format
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'response_code' => $this->faker->randomElement(['0', '1', '2']), // 0 = Success, 1 = Failed, 2 = Pending
            'response_message' => $this->faker->randomElement([
                'Transaction successful',
                'Transaction failed',
                'Transaction pending',
                'Insufficient funds',
                'Timeout occurred'
            ])
        ];
    }
}
