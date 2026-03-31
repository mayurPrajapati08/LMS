<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('categories')->insert([
            ['name' => 'Web Development', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Stack Development', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Data Science', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'AI/ML Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobile App Development', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
