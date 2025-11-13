<?php

namespace App\Repositories\Master;

use App\Models\MCategory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class MCategoryRepository extends BaseRepository
{
    public function __construct(MCategory $model)
    {
        parent::__construct($model);
    }

    public function findByHouse(int $houseId): Collection
    {
        return $this->model->where('house_id', $houseId)->get();
    }
}
