<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\CreateAdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesPermissionsSeeder::class,
            CreateAdminUserSeeder::class,

        ]);

    }
}
