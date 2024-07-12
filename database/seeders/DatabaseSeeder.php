<?php

namespace Database\Seeders;

use App\Models\CategoryInstall;
use App\Models\Group;
use App\Models\GroupBall;
use App\Models\Install;
use App\Models\InstallStage;
use App\Models\Service;
use App\Models\ServiceStage;
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
        CategoryInstall::insert([
            ['name' => 'Kamera', 'creator_id' => 1, 'created_at'=>now()],
            ['name' => 'Domofon', 'creator_id' => 1, 'created_at'=>now()],
            ['name' => 'Turniket', 'creator_id' => 1, 'created_at'=>now()],
            ['name' => 'Terminal', 'creator_id' => 1, 'created_at'=>now()]
        ]);

        InstallStage::insert([
            ['stage' => 1, 'text' => 'Blanka raqami'],
            ['stage' => 2, 'text' => 'Turgan joyidan geo lokatsiya'],
            ['stage' => 3, 'text' => 'Qilingan xaqida foto xisobot'],
            ['stage' => 4, 'text' => 'Olingan so’mma']
        ]);
        Install::factory()->count(300)->create();

        ServiceStage::insert([
            ['stage' => 1, 'text' => 'Muammo sababi foto xisobot'],
            ['stage' => 2, 'text' => 'Blanka raqami'],
            ['stage' => 3, 'text' => 'Turgan joyidan geo lokatsiya'],
            ['stage' => 4, 'text' => 'Ish bitganligi xaqida foto'],
            ['stage' => 5, 'text' => 'Olingan so’mma']
        ]);
        Service::factory()->count(200)->create();
    }
}
