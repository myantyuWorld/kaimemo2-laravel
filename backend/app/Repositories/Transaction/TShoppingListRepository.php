<?php

namespace App\Repositories\Transaction;

use App\Models\TShoppingList;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TShoppingListRepository extends BaseRepository
{
    public function __construct(TShoppingList $model)
    {
        parent::__construct($model);
    }

    public function findByHouse(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)->get();
    }

    public function findCompleted(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)
            ->where('is_completed', true)
            ->get();
    }

    public function findIncomplete(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)
            ->where('is_completed', false)
            ->get();
    }
}
