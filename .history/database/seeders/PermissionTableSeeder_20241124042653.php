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

            'Invoices',
            'Invoices Menu',
            'Paid Invoices',
            'Partially Paid Invoices',
            'Unpaid Invoices',
            'Archived Invoices',
            'Reports',
            'Invoices Reports',
            'Clients Reports',
            'Users',
            'Users Menu',
            'Users Authorities',
            'Settings',
            'Products',
            'Sections',


            'Add Invoice',
            'Delete Invoice',
            'Export Excel',
            'Change Payment Status',
            'Edit Invoice',
            'Archive Invoice',
            'Copy Invoice',
            'Add Attachment ',
            'Delete Attachment',

            'Add User',
            'Edit User',
            'Delete User',

            'Show Authority',
            'Add Authority',
            'Edit Authority',
            'Delete Authority',

            'Add Product',
            'Edit Product',
            'Delete Product',

            'Add Section',
            'Edit Section',
            'Delete Section',
            'Notifications',

    ];


    foreach ($permissions as $permission) {

        Permission::create(['name' => $permission]);
        }
    }
}
