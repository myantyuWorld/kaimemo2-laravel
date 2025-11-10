<?php

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteUserUseCase
{
    public function execute(User $user): void
    {
        Auth::logout();
        $user->delete();
    }
}
