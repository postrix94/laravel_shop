<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $access = config('permission.access');
        $roles = config('permission.roles');

        // create roles and assign created permissions
        foreach ($access as $typeAccess) {
            foreach ($typeAccess as $permission) {
                Permission::create(["name" => $permission]);
            }
        }



        //Moderator
        $moderatorRoles = array_merge(
            array_values($access['categories']),
            array_values($access['products']),
        );

        Role::create(['name' => $roles['moderator']])
            ->givePermissionTo($moderatorRoles);


        //Customer
        Role::create(['name' => $roles['customer']])
        ->givePermissionTo(array_values($access['account']));

        //Admin
        Role::create(['name' => $roles['admin']])
            ->givePermissionTo(Permission::all());


    }
}
