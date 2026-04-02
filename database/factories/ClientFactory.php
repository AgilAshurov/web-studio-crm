<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'website_url' => $this->faker->optional()->url(),
            'server_info' => $this->faker->optional()->ipv4(),
            'billing_contact' => [
                'name' => $this->faker->name(),
                'email' => $this->faker->safeEmail(),
                'phone' => $this->faker->phoneNumber(),
            ],
            'tech_contact' => [
                'name' => $this->faker->name(),
                'email' => $this->faker->safeEmail(),
                'phone' => $this->faker->phoneNumber(),
            ],
            'status' => $this->faker->randomElement(['active','inactive','prospect']),
            'notes' => [
                'comment' => $this->faker->sentence(),
                'tags' => $this->faker->words(3),
            ],
        ];
    }
}

