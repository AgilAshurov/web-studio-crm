<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['debit','credit','refund']),
            'amount' => $this->faker->randomFloat(2, 10, 5000),
            'status' => $this->faker->randomElement(['pending','success','failed','reversed']),
            'reference' => $this->faker->uuid(),
            'date' => $this->faker->date(),
        ];
    }
}

