<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MHouse extends Model
{
    use HasFactory;

    protected $table = 'm_houses';

    protected $fillable = [
        'created_user_id',
        'updated_user_id',
        'program_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(MUser::class, 't_house_relation', 'house_id', 'user_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(MCategory::class, 'house_id');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(MBudget::class, 'house_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(TExpense::class, 'house_id');
    }

    public function shoppingLists(): HasMany
    {
        return $this->hasMany(TShoppingList::class, 'house_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(TNotification::class, 'house_id');
    }

    public function notificationSetting(): HasOne
    {
        return $this->hasOne(MNotificationSetting::class, 'house_id');
    }

    public function houseRelations(): HasMany
    {
        return $this->hasMany(THouseRelation::class, 'house_id');
    }
}
