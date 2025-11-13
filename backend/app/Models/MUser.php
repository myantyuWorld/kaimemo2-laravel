<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MUser extends Model
{
    protected $table = 'm_users';

    protected $fillable = [
        'line_user_id',
        'name',
        'email',
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(MHouse::class, 't_house_relation', 'user_id', 'house_id');
    }

    public function houseRelations(): HasMany
    {
        return $this->hasMany(THouseRelation::class, 'user_id');
    }
}
