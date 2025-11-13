<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\UseCases\User\DestroyUserAction;
use App\UseCases\User\IndexUsersAction;
use App\UseCases\User\ShowUserAction;
use App\UseCases\User\StoreUserAction;
use App\UseCases\User\UpdateUserAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request, IndexUsersAction $action)
    {
        $users = $action->execute($request);

        return response()->json($users);
    }

    public function store(Request $request, StoreUserAction $action)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = $action->execute($request);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(User $user, ShowUserAction $action)
    {
        $result = $action->execute($user);

        return response()->json($result);
    }

    public function update(Request $request, User $user, UpdateUserAction $action)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:8',
        ]);

        $result = $action->execute($request, $user);

        return response()->json($result);
    }

    public function destroy(User $user, DestroyUserAction $action)
    {
        $action->execute($user);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
