<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::create([
            'name' => 'samirgamal',
            'email' => 'samir.gamal77@yahoo.com',
            'password' => bcrypt('123456'),
            'roles_name' => ["owner"],
            'Status' => 'Active',
        ]);
        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
