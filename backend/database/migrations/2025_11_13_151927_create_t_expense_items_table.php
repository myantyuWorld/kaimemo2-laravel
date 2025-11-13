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
        Schema::create('t_expense_items', function (Blueprint $table) {
            $table->id()->comment('支出明細ID');
            $table->unsignedBigInteger('category_id')->comment('カテゴリID');
            $table->unsignedBigInteger('expense_id')->comment('支出ID');
            $table->decimal('amount', 10, 2)->comment('支出金額');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->unsignedBigInteger('created_user_id')->nullable()->comment('作成者ID');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('更新者ID');
            $table->string('program_code', 50)->nullable()->comment('処理プログラムコード');

            $table->index('expense_id', 'i_t_expense_items_expense_id');
            $table->index('category_id', 'i_t_expense_items_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_expense_items');
    }
};
