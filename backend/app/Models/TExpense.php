<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TExpense extends Model
{
    protected $table = 't_expenses';

    protected $fillable = [
        'house_id',
        'expense_date',
        'memo',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(MHouse::class, 'house_id');
    }

    public function expenseItems(): HasMany
    {
        return $this->hasMany(TExpenseItem::class, 'expense_id');
    }
}
