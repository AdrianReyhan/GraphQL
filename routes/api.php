<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nuwave\Lighthouse\Http\GraphQLController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::middleware(['auth.token'])->post('/graphql', [GraphQLController::class, 'handle']);



Route::middleware(['validate.api.token'])->post('graphql', function (Illuminate\Http\Request $request) {
    return app('graphql')->executeQuery($request->input('query'), $request->all());
});