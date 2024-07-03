<?php

namespace Database\Factories;

use App\Models\Installation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Installation>
 */
class InstallationFactory extends Factory
{

    protected $model = Installation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => 1,
            'blanka_number' => fake()->name(),
            'address' => fake()->name(),
            'phone' => rand(900000000, 999999999),
            'area' => fake()->name,
            'location' => fake()->name,
            'latitude' => fake()->name,
            'longitude' => fake()->name,
            'status' => 1,
            'price' => rand(100000, 500000),
        ];
    }

}
