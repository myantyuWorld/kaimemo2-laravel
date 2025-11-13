<?php

namespace App\UseCases\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class StorePostAction
{
    public function execute(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->get('status', 'draft'),
            'user_id' => $request->user_id,
        ]);

        return $post->load('user');
    }
}
