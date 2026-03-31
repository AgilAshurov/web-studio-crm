<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        $period = $this->faker->randomElement(['monthly','yearly']);
        return [
            'title' => $this->faker->bs,
            'price' => $this->faker->randomFloat(2, 50, 500),
            'billing_period' => $period,
            'start_date' => $this->faker->date(),
            'next_payment_date' => $period === 'monthly' ? now()->addMonth() : now()->addYear(),
            'status' => 'active',
        ];
    }
}
