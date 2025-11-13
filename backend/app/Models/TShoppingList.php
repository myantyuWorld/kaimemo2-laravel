<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TShoppingList extends Model
{
    protected $table = 't_shopping_lists';

    protected $fillable = [
        'house_id',
        'title',
        'description',
        'is_completed',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(MHouse::class, 'house_id');
    }
}
