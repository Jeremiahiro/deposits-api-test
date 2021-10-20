<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Deposits Administrator',
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Deposits User',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $permissions = Permission::get()->all();

        $adminRole->givePermissionTo(
            array_map(function ($permission) {
                return $permission['name'];
            }, $permissions)
        );
    }
}
