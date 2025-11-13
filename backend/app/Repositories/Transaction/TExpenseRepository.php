<?php

namespace App\Repositories\Transaction;

use App\Models\TExpense;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TExpenseRepository extends BaseRepository
{
    public function __construct(TExpense $model)
    {
        parent::__construct($model);
    }

    public function findByHouse(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)->get();
    }

    public function findByDateRange(int $houseId, string $startDate, string $endDate): Collection
    {
        return $this->model->where('house_id', $houseId)
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->get();
    }
}
