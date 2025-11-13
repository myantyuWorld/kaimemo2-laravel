<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MNotificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_notification_settings')->insert([
            [
                'id' => 1,
                'house_id' => 1,
                'weekly_summary_enabled' => true,
                'budget_alert_enabled' => true,
                'preferred_channel' => 'push',
                'summary_day' => 'sunday',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
            [
                'id' => 2,
                'house_id' => 2,
                'weekly_summary_enabled' => true,
                'budget_alert_enabled' => true,
                'preferred_channel' => 'email',
                'summary_day' => 'monday',
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'program_code' => 'SEEDER',
            ],
        ]);
    }
}
