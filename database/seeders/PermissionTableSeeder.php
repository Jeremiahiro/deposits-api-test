<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'view-users',
                'display_name' => 'Can create users',
                'description' => 'Allow bearer to create users',
            ],
            [
                'name' => 'create-users',
                'display_name' => 'Can create users',
                'description' => 'Allow bearer to create users',
            ],
            [
                'name' => 'update-users',
                'display_name' => 'Can update users',
                'description' => 'Allow bearer to update users',
            ],
            [
                'name' => 'delete-users',
                'display_name' => 'Can delete users',
                'description' => 'Allow bearer to delete users',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
