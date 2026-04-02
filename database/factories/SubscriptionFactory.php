<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'billing_period' => $this->faker->randomElement(['month','year']),
            'start_date' => $this->faker->date(),
            'next_invoice_date' => $this->faker->date(),
            'payment_method' => $this->faker->randomElement(['cash','transfer']),
            'status' => $this->faker->randomElement(['active','paused','canceled','expired']),
            'notes' => $this->faker->sentence(),
        ];
    }
}

