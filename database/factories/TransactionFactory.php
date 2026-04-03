<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'type' => $this->faker->randomElement(['debit','refund']),
            'currency' => $this->faker->randomElement(['AZN','USD','EUR']),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['pending','success','failed']),
            'reference' => $this->faker->unique()->uuid,
            'date' => $this->faker->optional()->dateTimeThisYear(),
        ];
    }
}



