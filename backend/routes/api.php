<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => config('app.version', '1.0.0'),
    ]);
});

// Sample API endpoints
Route::prefix('v1')->group(function () {
    // Users API
    Route::apiResource('users', UserController::class);

    // Posts API
    Route::apiResource('posts', PostController::class);

    // Search endpoint
    Route::get('search', function (Request $request) {
        $query = $request->get('q', '');

        return response()->json([
            'query' => $query,
            'results' => [
                'users' => [],
                'posts' => [],
            ],
            'meta' => [
                'total' => 0,
                'page' => $request->get('page', 1),
                'per_page' => $request->get('per_page', 10),
            ],
        ]);
    });
});
