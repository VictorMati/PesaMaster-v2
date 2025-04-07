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
    public function definition()
    {
        $type = $this->faker->randomElement(['deposit', 'payment']);
        $paymentMethod = $this->faker->randomElement(['cash', 'mpesa']);
        $status = $this->faker->randomElement(['pending', 'completed', 'failed']);
        $amount = $this->faker->randomFloat(2, 100, 5000);

        $description = match ($type) {
            'deposit' => "Deposit of KES {$amount} made via {$paymentMethod}. Status: {$status}.",
            'payment' => "Payment of KES {$amount} processed through {$paymentMethod}. Status: {$status}.",
            default => 'Transaction record.'
        };

        return [
            'user_id' => 1,
            'amount' => $amount,
            'type' => $type,
            'transaction_date' => now(),
            'status' => $status,
            'description' => $description,
            'payment_method' => $paymentMethod,
            'phone_number' => '07' . $this->faker->numberBetween(10000000, 99999999), // Kenyan number
        ];
    }

}
