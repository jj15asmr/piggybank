<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DomainPrice>
 */
class DomainPriceFactory extends Factory
{
    /**
     * TLDs that will be used for the factory definition as Faker doesn't provide enough unique ones.
     * 
     * @var array
     */
    private array $tlds = [
        'com', 'net', 'org', 'edu', 'info', 'biz', 'co', 'io', 'xyz', 'me'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tld' => fake()->unique()->randomElement($this->tlds),

            'registration_price' => fake()->randomNumber(4),
            'renewal_price' => fake()->randomNumber(4),
        ];
    }
}
