<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::controller(UserController::class)->group(function () {
        Route::put('/profilePhoto', 'profilePhoto');
        Route::delete('/profilePhoto', 'destroyPhoto');
        Route::put('/profile', 'update');
    });

    Route::controller(TaskController::class)->group(function () {
        Route::get('/tasks', 'index');
        Route::post('/tasks', 'store');
        Route::post('/tasks/{id}', 'show');
        Route::put('/tasks/{id}', 'update');
        Route::delete('/tasks/{id}', 'destroy');
    });
});
