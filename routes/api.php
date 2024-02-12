<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/token', [LoginController::class, 'token'])->name('api.login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/tasks', [TaskController::class, 'index']   )->name('api.tasks.index');
    Route::post('/tasks', [TaskController::class, 'store']   )->name('api.tasks.store');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('api.tasks.show');
    Route::put('/tasks/{id}', [TaskController::class, 'update']   )->name('api.tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('api.tasks.destroy');

});
