<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\FavoriteCharacterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('characters', [CharacterController::class, 'index'])->name('characters.index');
Route::get('characters/{id}', [CharacterController::class, 'show']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('favorites', [FavoriteCharacterController::class, 'store']);
    Route::get('favorites', [FavoriteCharacterController::class, 'index']);
    Route::delete('favorites/{id}', [FavoriteCharacterController::class, 'destroy']);
});