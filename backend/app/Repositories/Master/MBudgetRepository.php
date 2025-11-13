<?php

namespace App\Repositories\Master;

use App\Models\MBudget;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class MBudgetRepository extends BaseRepository
{
    public function __construct(MBudget $model)
    {
        parent::__construct($model);
    }

    public function findByHouse(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)->get();
    }

    public function findByCategory(int $categoryId): Collection
    {
        return $this->model->where('category_id', $categoryId)->get();
    }
}
