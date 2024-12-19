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
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);

        //fetch roles
        $adminRole = Role::where('name','Admin')->first();
        $userRole = Role::where('name','User')->first();

         // Check if roles were created successfully
         if (!$adminRole || !$userRole) {
            dd('Error: Role creation failed');
        }

        //assign permissions to roles
        $permissions = Permission::all();
        if ($permissions->isEmpty()) {
            dd('Error: No permissions found');
        }
        $adminRole->permissions()->sync($permissions->pluck('id')->toArray());

        $userRole->permissions()->sync(
            Permission::whereIn('name', ['Invoices', 'Invoices Menu', 'Notifications'])->pluck('id')->toArray()
        );

    }
}
