<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'sara_mohamed',
            'email' => 'aa496012772@gmail.com',
            'password' => bcrypt('123456'),
            'status'=>'active',
            ]);

            $adminRole=Role::where('name','Admin')->first();
            $user->roles()->attach($adminRole);
    }
}
