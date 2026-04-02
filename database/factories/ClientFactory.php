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
            'website_url' => $this->faker->url(),
            'server_info' => $this->faker->domainWord(),
            'billing_contact' => ['name'=>$this->faker->name(),'email'=>$this->faker->email()],
            'tech_contact' => ['name'=>$this->faker->name(),'email'=>$this->faker->email()],
            'status' => $this->faker->randomElement(['active','inactive','prospect']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
