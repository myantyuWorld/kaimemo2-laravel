<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\UseCases\Post\DestroyPostAction;
use App\UseCases\Post\IndexPostsAction;
use App\UseCases\Post\ShowPostAction;
use App\UseCases\Post\StorePostAction;
use App\UseCases\Post\UpdatePostAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(Request $request, IndexPostsAction $action)
    {
        $posts = $action->execute($request);

        return response()->json($posts);
    }

    public function store(Request $request, StorePostAction $action)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'sometimes|in:draft,published,archived',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = $action->execute($request);

        return response()->json($post, Response::HTTP_CREATED);
    }

    public function show(Post $post, ShowPostAction $action)
    {
        $result = $action->execute($post);

        return response()->json($result);
    }

    public function update(Request $request, Post $post, UpdatePostAction $action)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'status' => 'sometimes|in:draft,published,archived',
        ]);

        $result = $action->execute($request, $post);

        return response()->json($result);
    }

    public function destroy(Post $post, DestroyPostAction $action)
    {
        $action->execute($post);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
