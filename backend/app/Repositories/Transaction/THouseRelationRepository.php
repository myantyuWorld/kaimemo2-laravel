<?php

namespace App\Repositories\Transaction;

use App\Models\THouseRelation;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class THouseRelationRepository extends BaseRepository
{
    public function __construct(THouseRelation $model)
    {
        parent::__construct($model);
    }

    public function findByUser(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function findByHouse(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)->get();
    }
}
