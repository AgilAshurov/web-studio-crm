<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'period_start' => $this->faker->date(),
            'period_end' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'paid_amount' => $this->faker->randomFloat(2, 0, 10000),
            'payment_date' => $this->faker->optional()->date(),
            'payment_method' => $this->faker->randomElement(['cash','transfer']),
            'status' => $this->faker->randomElement(['pending','partially_paid','paid','overdue','canceled']),
            'notes' => $this->faker->sentence(),

            'project_id' => null,
            'subscription_id' => null,
        ];
    }
}

