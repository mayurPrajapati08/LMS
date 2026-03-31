<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@test.com',
                'password' => Hash::make('123456'),
                'role_id' => 1, // super admin
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mayur',
                'email' => 'mayurprajapati0805@gmail.com',
                'password' => Hash::make('123456'),
                'role_id' => 2, // admin
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mukesh Patel',
                'email' => 'joshipatel348@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 3, // instructor
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mayur Prajapati',
                'email' => 'mayurprjpati03@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 4, // user
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
