<?php

namespace App\Repositories\Master;

use App\Models\MUser;
use App\Repositories\BaseRepository;

class MUserRepository extends BaseRepository
{
    public function __construct(MUser $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?MUser
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByLineUserId(string $lineUserId): ?MUser
    {
        return $this->model->where('line_user_id', $lineUserId)->first();
    }
}
