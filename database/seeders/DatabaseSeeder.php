<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Client::factory(10)
            ->has(Project::factory()->count(3))
            ->has(Subscription::factory()->count(2)->state(fn() => [
                'billing_period' => fake()->randomElement(['month','year']),
            ]))
            ->create()
            ->each(function ($client) {
                // создаём несколько инвойсов случайным образом
                for ($i = 0; $i < rand(2, 5); $i++) {
                    $invoice = Invoice::factory()->create([
                        'client_id' => $client->id,
                        // случайно выбираем проект или подписку
                        'project_id' => fake()->boolean() ? $client->projects->random()->id : null,
                        'subscription_id' => fake()->boolean() ? $client->subscriptions->random()->id : null,
                    ]);

                    // создаём случайное количество транзакций
                    Transaction::factory()->count(rand(1, 3))->create([
                        'invoice_id' => $invoice->id,
                    ]);
                }
            });
    }


}
