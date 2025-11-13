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
        Schema::create('t_notifications', function (Blueprint $table) {
            $table->id()->comment('通知ID');
            $table->unsignedBigInteger('house_id')->comment('家ID');
            $table->enum('notification_type', ['budget_alert', 'weekly_summary', 'expense_reminder'])->comment('通知タイプ（budget_alert=予算アラート、weekly_summary=週次サマリー、expense_reminder=支出リマインダー）');
            $table->string('title')->default('')->comment('通知タイトル');
            $table->string('message', 1000)->default('')->comment('通知メッセージ');
            $table->json('notification_data')->nullable()->comment('追加データ（JSON形式）');
            $table->enum('notification_channel', ['push', 'email', 'line'])->default('push')->comment('通知チャンネル（push=プッシュ通知、email=メール、line=LINE）');
            $table->enum('notification_status', ['pending', 'sent', 'failed'])->default('pending')->comment('送信ステータス（pending=送信待ち、sent=送信済み、failed=送信失敗）');
            $table->timestamp('sent_at')->nullable()->comment('送信日時');
            $table->timestamp('read_at')->nullable()->comment('既読日時');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->unsignedBigInteger('created_user_id')->nullable()->comment('作成者ID');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('更新者ID');
            $table->string('program_code', 50)->nullable()->comment('処理プログラムコード');

            $table->index('house_id', 'i_t_notifications_house_id');
            $table->index('notification_status', 'i_t_notifications_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_notifications');
    }
};
