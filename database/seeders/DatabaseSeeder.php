<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make(123),
            'role' => 1,
            'status' => 1,
            'email' => 'admin@example.com',
        ]);

        Group::factory()->create();
    }
}
