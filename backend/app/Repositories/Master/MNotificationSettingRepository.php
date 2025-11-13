<?php

namespace App\Repositories\Master;

use App\Models\MNotificationSetting;
use App\Repositories\BaseRepository;

class MNotificationSettingRepository extends BaseRepository
{
    public function __construct(MNotificationSetting $model)
    {
        parent::__construct($model);
    }

    public function findByHouse(int $houseId): ?MNotificationSetting
    {
        return $this->model->where('house_id', $houseId)->first();
    }
}
