<?php

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(Request $request, User $user)
    {
        $user->update(array_filter([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,
        ]));

        return $user->load('posts');
    }
}
