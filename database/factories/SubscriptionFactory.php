<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeThisYear();

        // случайно выбираем +1 месяц или +1 год
        $end = fake()->boolean()
            ? (clone $start)->modify('+1 month')
            : (clone $start)->modify('+1 year');
        return [
            'client_id' => Client::factory(),
            'title' => $this->faker->sentence(2),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'billing_period' => $this->faker->randomElement(['monthly','yearly']), // ✅ совпадает с миграцией
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'next_invoice_date' => $this->faker->optional()->date(),
            'payment_method' => $this->faker->randomElement(['cash','transfer']),
            'status' => $this->faker->randomElement(['active','paused','canceled','expired']),
            'notes' => [
                'comment' => $this->faker->sentence(),
                'tags' => $this->faker->words(3),
            ],
        ];
    }
}



