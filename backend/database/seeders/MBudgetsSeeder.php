<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MBudgetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_budgets')->insert([
            [
                'id' => 1,
                'house_id' => 1,
                'category_id' => 1,
                'amount' => 50000.00,
                'period_type' => 'monthly',
                'active_from' => '2025-01-01',
                'active_to' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 2,
                'house_id' => 1,
                'category_id' => 2,
                'amount' => 20000.00,
                'period_type' => 'monthly',
                'active_from' => '2025-01-01',
                'active_to' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
        ]);
    }
}
