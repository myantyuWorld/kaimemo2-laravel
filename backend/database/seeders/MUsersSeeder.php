<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_users')->insert([
            [
                'id' => 1,
                'line_user_id' => null,
                'name' => 'テストユーザー1',
                'email' => 'test1@example.com',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 2,
                'line_user_id' => null,
                'name' => 'テストユーザー2',
                'email' => 'test2@example.com',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
        ]);
    }
}
