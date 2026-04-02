<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Пользователи
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        // Клиенты с проектами и подписками
        Client::factory(10)
            ->has(Project::factory()->count(3))
            ->has(Subscription::factory()->count(2))
            ->create()
            ->each(function ($client) {
                // Инвойсы
                for ($i = 0; $i < rand(2, 5); $i++) {
                    $invoice = Invoice::factory()->create([
                        'client_id' => $client->id,
                        'project_id' => fake()->boolean() ? $client->projects->random()->id : null,
                        'subscription_id' => fake()->boolean() ? $client->subscriptions->random()->id : null,
                    ]);

                    // Транзакции
                    Transaction::factory()->count(rand(1, 3))->create([
                        'invoice_id' => $invoice->id,
                    ]);
                }
            });
    }
}

