<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MBudget extends Model
{
    protected $table = 'm_budgets';

    protected $fillable = [
        'house_id',
        'category_id',
        'amount',
        'period_type',
        'active_from',
        'active_to',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'active_from' => 'date',
        'active_to' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(MHouse::class, 'house_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MCategory::class, 'category_id');
    }
}
