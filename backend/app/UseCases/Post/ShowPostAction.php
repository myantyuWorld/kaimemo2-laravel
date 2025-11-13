<?php

namespace App\UseCases\Post;

use App\Models\Post;

class ShowPostAction
{
    public function execute(Post $post)
    {
        return $post->load('user');
    }
}
