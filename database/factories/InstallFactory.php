<?php

namespace Database\Factories;

use App\Models\Install;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Install>
 */
class InstallFactory extends Factory
{

    protected $model = Install::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = [1, 2, 3, 4];
        $status = [1, 2, 3, 4, 5, 6, 7, 8];

        return [
            'category_id' =>  $category[array_rand($category)],
            'blanka_number' => fake()->name(),
            'name' => fake()->name(),
            'address' => fake()->name(),
            'phone' => rand(900000000, 999999999),
            'area' => fake()->name,
            'location' => fake()->name,
            'latitude' => fake()->name,
            'longitude' => fake()->name,
            'status' => $status[array_rand($status)],
            'price' => rand(100000, 500000),
        ];
    }

}
