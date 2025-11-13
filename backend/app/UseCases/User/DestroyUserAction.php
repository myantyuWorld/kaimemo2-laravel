<?php

namespace App\UseCases\User;

use App\Models\User;

class DestroyUserAction
{
    public function execute(User $user)
    {
        $user->delete();
    }
}
