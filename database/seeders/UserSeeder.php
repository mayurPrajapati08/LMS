<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'super admin' => Role::query()->firstOrCreate(['name' => 'super admin'])->id,
            'admin' => Role::query()->firstOrCreate(['name' => 'admin'])->id,
            'instructor' => Role::query()->firstOrCreate(['name' => 'instructor'])->id,
            'user' => Role::query()->firstOrCreate(['name' => 'user'])->id,
            'hr team' => Role::query()->firstOrCreate(['name' => 'hr team'])->id,
        ];

        $users = [
            [
                'name' => 'Mayur Prajapati',
                'email' => 'mayurprjapati07@gmail.com',
                'password' => '123456',
                'role_id' => $roles['super admin'],
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role_id' => $user['role_id'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
