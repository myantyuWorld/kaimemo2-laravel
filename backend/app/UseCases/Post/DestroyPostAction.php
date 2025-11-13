<?php

namespace App\UseCases\Post;

use App\Models\Post;

class DestroyPostAction
{
    public function execute(Post $post)
    {
        $post->delete();
    }
}
