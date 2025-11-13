<?php

namespace App\Repositories\Transaction;

use App\Models\TExpenseItem;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TExpenseItemRepository extends BaseRepository
{
    public function __construct(TExpenseItem $model)
    {
        parent::__construct($model);
    }

    public function findByExpense(int $expenseId): Collection
    {
        return $this->model->where('expense_id', $expenseId)->get();
    }

    public function findByCategory(int $categoryId): Collection
    {
        return $this->model->where('category_id', $categoryId)->get();
    }
}
