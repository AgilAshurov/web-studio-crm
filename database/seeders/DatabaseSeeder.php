<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Note;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Пользователи
        $users = User::factory(5)->create();

        // Клиенты
        Client::factory(15)->create()->each(function ($client) use ($users) {
            switch (rand(0,3)) {
                case 0:
                    // клиент без проектов и подписок
                    break;
                case 1:
                    // только проекты
                    Project::factory(rand(1,3))->create(['client_id' => $client->id]);
                    break;
                case 2:
                    // только подписки
                    Subscription::factory(rand(1,2))->create(['client_id' => $client->id]);
                    break;
                case 3:
                    // и проекты, и подписки
                    Project::factory(rand(1,2))->create(['client_id' => $client->id]);
                    Subscription::factory(rand(1,2))->create(['client_id' => $client->id]);
                    break;
            }
        });

        // Платежи
        Project::all()->each(function ($project) {
            if (rand(0,1)) {
                Payment::factory(rand(1,3))->create([
                    'project_id' => $project->id,
                    'client_id'  => $project->client_id,
                    'subscription_id' => null,
                ]);
            }
        });

        Subscription::all()->each(function ($subscription) {
            if (rand(0,1)) {
                Payment::factory(rand(1,2))->create([
                    'subscription_id' => $subscription->id,
                    'client_id'       => $subscription->client_id,
                    'project_id'      => null,
                ]);
            }
        });

        // Заметки
        $users->each(function ($user) {
            if (rand(0,1)) {
                Note::factory(rand(1,5))->create([
                    'user_id' => $user->id,
                    'noteable_id' => Client::inRandomOrder()->first()->id,
                    'noteable_type' => Client::class,
                ]);
            }
        });
    }
}

