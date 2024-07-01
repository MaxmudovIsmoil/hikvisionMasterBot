<?php

namespace Database\Seeders;

use App\Models\CategoryInstallation;
use App\Models\Group;
use App\Models\GroupBall;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'job' => 'administrator',
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make(123),
            'role' => 1,
            'status' => 1,
            'email' => 'admin@example.com',
        ]);

        User::factory(20)->create();

        Group::factory(5)->create();
        GroupBall::factory()->create();
        CategoryInstallation::insert([
            ['name' => 'Kamera'],
            ['name' => 'Domofon'],
            ['name' => 'Turniket'],
            ['name' => 'Terminal']
        ]);
    }
}
