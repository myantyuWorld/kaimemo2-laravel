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
        Schema::create('m_budgets', function (Blueprint $table) {
            $table->id()->comment('予算ID');
            $table->unsignedBigInteger('house_id')->comment('家ID');
            $table->unsignedBigInteger('category_id')->comment('カテゴリID');
            $table->decimal('amount', 10, 2)->comment('予算金額');
            $table->enum('period_type', ['monthly', 'weekly', 'daily'])->comment('期間タイプ（monthly=月次、weekly=週次、daily=日次）');
            $table->date('active_from')->comment('有効期間開始日');
            $table->date('active_to')->nullable()->comment('有効期間終了日');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->unsignedBigInteger('created_user_id')->nullable()->comment('作成者ID');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('更新者ID');
            $table->string('program_code', 50)->nullable()->comment('処理プログラムコード');

            $table->index('house_id', 'i_m_budgets_house_id');
            $table->index('category_id', 'i_m_budgets_category_id');
            $table->index(['active_from', 'active_to'], 'i_m_budgets_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_budgets');
    }
};
