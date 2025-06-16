<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::post('graphql', 'GraphQLController@query');
});


Route::middleware(['validate.api.token'])->post('graphql', function (Illuminate\Http\Request $request) {
    return app('graphql')->executeQuery($request->input('query'), $request->all());
});