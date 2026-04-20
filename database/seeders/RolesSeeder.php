<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        collect([
            'super admin',
            'admin',
            'instructor',
            'user',
            'hr team',
        ])->each(function (string $roleName) {
            DB::table('roles')->updateOrInsert(
                ['name' => $roleName],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        });
    }
}
