<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('da-test')->group(function() {

    Route::get('/todos', [TodoController::class, 'getAll']);
    Route::get('/todo-item/{id}', [TodoController::class, 'show']);
    Route::post('/create', [TodoController::class, 'store']);
    Route::patch('/update/{id}', [TodoController::class, 'update']);
    Route::delete('/remove/{id}', [TodoController::class, 'destroy']);
});