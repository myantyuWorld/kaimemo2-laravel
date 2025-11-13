<?php

namespace App\Repositories\Master;

use App\Models\MHouse;
use App\Repositories\BaseRepository;

class MHouseRepository extends BaseRepository
{
    public function __construct(MHouse $model)
    {
        parent::__construct($model);
    }
}
