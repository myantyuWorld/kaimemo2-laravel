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
        Schema::create('t_shopping_lists', function (Blueprint $table) {
            $table->id()->comment('買い物リストID');
            $table->unsignedBigInteger('house_id')->comment('家ID');
            $table->string('title')->default('')->comment('タイトル');
            $table->string('description', 1000)->default('')->comment('説明');
            $table->boolean('is_completed')->default(false)->comment('完了フラグ');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->unsignedBigInteger('created_user_id')->nullable()->comment('作成者ID');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('更新者ID');
            $table->string('program_code', 50)->nullable()->comment('処理プログラムコード');

            $table->index('house_id', 'i_t_shopping_lists_house_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_shopping_lists');
    }
};
