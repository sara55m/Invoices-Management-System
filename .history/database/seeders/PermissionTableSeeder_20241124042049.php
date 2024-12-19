<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            'invoices',
            'invoices menu',
            'paid invoices',
            'partially paid invoices',
            'unpaid invoices',
            'invoices archive',
            'reports',
            'invoices reports',
            'customers reports',
            'users',
            'users menu',
            'users authorities',
            'settings',
            'products',
            'sections',


            'add invoice',
            'delete invoice',
            'export EXCEL',
            'change payment status',
            'edit invoice',
            'archive invoice',
            'copy invoice',
            'add attachment ',
            'delete attachment',

            'add user',
            'edit user',
            'delete user',

            'show authority',
            'add authority',
            'edit authority',
            'delete authority',

            'add product',
            'edit product',
            'delete product',

            'add section',
            'edit section',
            'delete section',
            'notifications',

    ];


    foreach ($permissions as $permission) {

        Permission::create(['name' => $permission]);
        }
    }
}
