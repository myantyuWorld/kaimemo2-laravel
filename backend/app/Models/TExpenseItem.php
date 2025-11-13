<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TExpenseItem extends Model
{
    protected $table = 't_expense_items';

    protected $fillable = [
        'category_id',
        'expense_id',
        'amount',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MCategory::class, 'category_id');
    }

    public function expense(): BelongsTo
    {
        return $this->belongsTo(TExpense::class, 'expense_id');
    }
}
