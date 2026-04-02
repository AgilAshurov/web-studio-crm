<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->catchPhrase(),
            'description' => $this->faker->paragraph(),
            'total_amount' => $this->faker->randomFloat(2, 1000, 50000),
            'status' => $this->faker->randomElement(['draft','active','completed','paused','canceled']),
            'notes' => $this->faker->sentence(),
        ];
    }
}

