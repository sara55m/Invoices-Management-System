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
        //create a new user
        $user1 = User::create([
            'name' => 'sara_mohamed',
            'email' => 'aa496012772@gmail.com',
            'password' => bcrypt('123456'),
            'status'=>'active',
            'image'=>'1734231309.jpg',
            ]);
            //attach role tp user
            $adminRole=Role::where('name','Admin')->first();
            $user1->roles()->attach($adminRole);

            $user2 = User::create([
                'name' => 'hana_mohamed',
                'email' => 'aa24375610@gmail.com',
                'password' => bcrypt('123456789'),
                'status'=>'active',
                'image'=>'1734233090.jpg',
                ]);
                //attach role tp user
                $userRole=Role::where('name','User')->first();
                $user2->roles()->attach($userRole);

                $user3 = User::create([
                    'name' => 'amira',
                    'email' => 'amira123@gmail.com',
                    'password' => bcrypt('123456'),
                    'status'=>'active',
                    'image'=>'1734308613.jpg',
                    ]);
                    //attach role tp user
                     $user3->roles()->attach($adminRole);

    }
}
