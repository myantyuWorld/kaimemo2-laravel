<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class THouseRelation extends Model
{
    protected $table = 't_house_relation';

    protected $fillable = [
        'user_id',
        'house_id',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(MUser::class, 'user_id');
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(MHouse::class, 'house_id');
    }
}
