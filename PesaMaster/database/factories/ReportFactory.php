<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['financial', 'audit', 'usage']),
            'total_income' => $this->faker->randomFloat(2, 500, 50000),
            'total_expenses' => $this->faker->randomFloat(2, 100, 45000),
            'status' => $this->faker->randomElement(['generated', 'pending']),
            'period' => Carbon::now()->subMonths(rand(0, 12))->format('Y-m'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
