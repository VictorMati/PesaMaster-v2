<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'user_id' => 1, // Creates a user if not provided
            'name' => $this->faker->word . ' Account',
            'balance' => $this->faker->randomFloat(2, 100, 10000), // Random balance between 100 and 10000
        ];
    }
}
