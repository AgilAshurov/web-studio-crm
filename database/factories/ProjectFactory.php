<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'total_amount' => $this->faker->randomFloat(2, 1000, 50000),
            'status' => $this->faker->randomElement(['draft','active','completed','paused','canceled']),
            'notes' => [
                'manager' => $this->faker->name(),
                'priority' => $this->faker->randomElement(['low','medium','high']),
                'tags' => $this->faker->words(3),
            ],
        ];
    }
}



