<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'company_name' => $this->faker->company,
            'website_url' => $this->faker->url,
            'server_info' => $this->faker->sentence,
            'billing_contact' => json_encode([
                'name'=>$this->faker->name,
                'phone'=>$this->faker->phoneNumber,
                'email'=>$this->faker->email
            ]),
            'tech_contact' => json_encode([
                'name'=>$this->faker->name,
                'phone'=>$this->faker->phoneNumber,
                'email'=>$this->faker->email
            ]),
        ];
    }
}
