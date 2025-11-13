<?php

namespace App\UseCases\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class UpdatePostAction
{
    public function execute(Request $request, Post $post)
    {
        $post->update($request->only(['title', 'content', 'status']));

        return $post->load('user');
    }
}
