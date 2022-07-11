<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create student permissions
        Permission::updateOrCreate(['name' => 'list only my courses']);
        Permission::updateOrCreate(['name' => 'show only my course']);
        Permission::updateOrCreate(['name' => 'show only my user']);
        Permission::updateOrCreate(['name' => 'update only my user']);

        $student = Role::updateOrCreate(['name' => 'student']);
        $student->givePermissionTo(Permission::all());

        // Create teacher permissions
        Permission::updateOrCreate(['name' => 'update only my course']);
        Permission::updateOrCreate(['name' => 'list only my users']);

        $teacher = Role::updateOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo(Permission::all());

        // Create admin permissions
        Permission::updateOrCreate(['name' => 'list users']);
        Permission::updateOrCreate(['name' => 'show user']);
        Permission::updateOrCreate(['name' => 'create user']);
        Permission::updateOrCreate(['name' => 'update user']);
        Permission::updateOrCreate(['name' => 'delete user']);

        Permission::updateOrCreate(['name' => 'list courses']);
        Permission::updateOrCreate(['name' => 'show course']);
        Permission::updateOrCreate(['name' => 'create course']);
        Permission::updateOrCreate(['name' => 'update course']);
        Permission::updateOrCreate(['name' => 'delete course']);

        Permission::updateOrCreate(['name' => 'list access codes']);
        Permission::updateOrCreate(['name' => 'show access code']);
        Permission::updateOrCreate(['name' => 'create access code']);
        Permission::updateOrCreate(['name' => 'update access code']);
        Permission::updateOrCreate(['name' => 'delete access code']);

        Permission::updateOrCreate(['name' => 'manage settings']);
        Permission::updateOrCreate(['name' => 'manage roles']);
        Permission::updateOrCreate(['name' => 'manage translations']);
        Permission::updateOrCreate(['name' => 'manage backup']);

        $admin = Role::updateOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
