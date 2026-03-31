<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'payment_date' => $this->faker->dateTimeThisYear,
            'payment_method' => $this->faker->randomElement(['cash','bank','card']),
            'period_start' => now()->startOfMonth(),
            'period_end' => now()->endOfMonth(),
        ];
    }
}
