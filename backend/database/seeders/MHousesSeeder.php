<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_houses')->insert([
            [
                'id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
        ]);
    }
}
