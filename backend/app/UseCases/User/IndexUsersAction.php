<?php

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Http\Request;

class IndexUsersAction
{
    public function execute(Request $request)
    {
        return User::with('posts')
            ->when($request->search, fn ($query) => $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'))
            ->paginate($request->get('per_page', 15));
    }
}
