<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'client_id'    => Client::factory(),
            'title' => $this->faker->catchPhrase,
            'total_amount' => $this->faker->randomFloat(2, 1000, 10000),
            'paid_amount' => 0,
            'status' => $this->faker->randomElement(['lead','active','completed','cancelled']),
        ];
    }
}
