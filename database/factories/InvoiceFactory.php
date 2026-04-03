<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeThisYear();
        $end = (clone $start)->modify('+1 month');

        return [
            'client_id' => Client::factory(),
            'project_id' => $this->faker->optional()->randomElement([Project::factory()]),
            'subscription_id' => $this->faker->optional()->randomElement([Subscription::factory()]),
            'billing_period_start' => $start,
            'billing_period_end' => $end,
            'currency' => $this->faker->randomElement(['AZN','USD','EUR']),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'factical_amount' => $this->faker->randomFloat(2, 0, 5000),
            'payment_date' => $this->faker->optional()->dateTimeThisYear(),
            'payment_method' => $this->faker->optional()->randomElement(['cash','transfer']),
            'status' => $this->faker->randomElement(['pending','paid','partially_paid','refuned','partially_refuned','canceled']),
            'notes' => [
                'comment' => $this->faker->sentence(),
                'tags' => $this->faker->words(3),
            ],
        ];
    }
}
