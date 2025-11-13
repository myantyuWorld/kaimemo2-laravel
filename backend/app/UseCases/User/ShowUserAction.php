<?php

namespace App\UseCases\User;

use App\Models\User;

class ShowUserAction
{
    public function execute(User $user)
    {
        return $user->load('posts');
    }
}
