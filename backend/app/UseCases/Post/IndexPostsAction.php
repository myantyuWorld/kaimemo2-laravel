<?php

namespace App\UseCases\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexPostsAction
{
    public function execute(Request $request)
    {
        return Post::with('user')
            ->when($request->status, fn ($query) => $query->where('status', $request->status))
            ->when($request->search, fn ($query) => $query->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('content', 'like', '%'.$request->search.'%'))
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));
    }
}
