<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_categories')->insert([
            [
                'id' => 1,
                'house_id' => 1,
                'name' => '食費',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 2,
                'house_id' => 1,
                'name' => '交通費',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 3,
                'house_id' => 1,
                'name' => '娯楽費',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 4,
                'house_id' => 1,
                'name' => '日用品',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 5,
                'house_id' => 1,
                'name' => '光熱費',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
        ]);
    }
}
