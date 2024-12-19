<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
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

        // Create Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);

        //assign permissions to roles
        $adminRole->permissions()->sync(Permission::all()->pluck('id')->toArray());

        /*$userRole->permissions()->sync(
            Permission::whereIn('name', ['Invoices','Invoices Menu','Notifications'])->pluck('id')->toArray()
        );*/

    }
}
