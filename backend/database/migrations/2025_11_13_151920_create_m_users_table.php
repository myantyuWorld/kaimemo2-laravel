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
        Schema::create('m_users', function (Blueprint $table) {
            $table->id()->comment('ユーザーID');
            $table->string('line_user_id')->nullable()->comment('LINE ユーザーID');
            $table->string('name')->default('')->comment('ユーザー名');
            $table->string('email')->nullable()->comment('メールアドレス');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->unsignedBigInteger('created_user_id')->nullable()->comment('作成者ID');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('更新者ID');
            $table->string('program_code', 50)->nullable()->comment('処理プログラムコード');

            $table->unique('line_user_id', 'ui_m_users_line_user_id');
            $table->unique('email', 'ui_m_users_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_users');
    }
};
