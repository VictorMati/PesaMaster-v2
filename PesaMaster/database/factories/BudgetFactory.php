<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        $budgetLimit = $this->faker->randomFloat(2, 100, 100000);
        $currentExpense = $this->faker->randomFloat(2, 0, $budgetLimit * 0.9); // Ensure it doesn't always exceed

        return [
            'user_id' => 1,
            'category' => $this->faker->randomElement(['groceries', 'rent', 'entertainment', 'utilities']),
            'budget_limit' => $budgetLimit,
            'current_expense' => $currentExpense,
            'status' => $currentExpense > $budgetLimit ? 'exceeded' : 'active',
            'period' => Carbon::now()->subMonths(rand(0, 12))->format('Y-m'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
