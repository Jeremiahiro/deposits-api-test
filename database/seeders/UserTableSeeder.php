<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User */
        $dev = User::factory()->create([
            'email' => 'dev@deposits.com',
            'email_verified_at' => Carbon::now()
        ]);

        $dev->assignRole(
            Role::whereIn('name', ['admin', 'user'])->get()
        );

        User::factory()->count(30)->create()->each(function ($user) {
            $user->assignRole(Role::whereIn('name', ['user'])->get());
        });
    }
}