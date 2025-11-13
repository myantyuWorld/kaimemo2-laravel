<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_notification_settings', function (Blueprint $table) {
            $table->id()->comment('通知設定ID');
            $table->unsignedBigInteger('house_id')->comment('家ID');
            $table->boolean('weekly_summary_enabled')->default(true)->comment('週次サマリー通知有効フラグ');
            $table->boolean('budget_alert_enabled')->default(true)->comment('予算アラート通知有効フラグ');
            $table->enum('preferred_channel', ['push', 'email', 'line'])->default('push')->comment('優先通知チャンネル（push=プッシュ通知、email=メール、line=LINE）');
            $table->enum('summary_day', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'])->default('sunday')->comment('サマリー送信曜日');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->unsignedBigInteger('created_user_id')->nullable()->comment('作成者ID');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('更新者ID');
            $table->string('program_code', 50)->nullable()->comment('処理プログラムコード');

            $table->unique('house_id', 'ui_m_notification_settings_house_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_notification_settings');
    }
};
