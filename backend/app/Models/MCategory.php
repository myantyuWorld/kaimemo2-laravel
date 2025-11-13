<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MCategory extends Model
{
    protected $table = 'm_categories';

    protected $fillable = [
        'house_id',
        'name',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(MHouse::class, 'house_id');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(MBudget::class, 'category_id');
    }

    public function expenseItems(): HasMany
    {
        return $this->hasMany(TExpenseItem::class, 'category_id');
    }
}
