<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'level' => fake()->name,
            'ball' => rand(min: 100, max: 350),
            'count' => rand(1, 6),
            'status' => 1,
            'phone' => rand(900000000, 999999999),
        ];
    }

}
