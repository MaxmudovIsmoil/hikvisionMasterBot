<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = [
            'A group',
            'B group',
            'C group',
        ];

        $level = ['middle', 'senior', 'junior'];
        return [
            'name' => $group[array_rand($group)],
            'level' => $level[array_rand($level)],
            'ball' => rand(min: 100, max: 350),
            'count' => rand(1, 6),
            'status' => 1,
            'phone' => rand(900000000, 999999999),
        ];
    }

}
