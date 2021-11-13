<?php

use App\Http\Controllers\API\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/productos', [ProductoController::class, 'index']);
// Route::post('/productos', [ProductoController::class, 'store']);
// Route::get('/productos/{producto}', [ProductoController::class, 'show']);
// Route::put('/productos/{producto}', [ProductoController::class, 'update']);
// Route::delete('/productos/{producto}', [ProductoController::class, 'destroy']);
Route::apiResource('productos', ProductoController::class);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\Api\AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [\App\Http\Controllers\Api\AuthController::class, 'me'])->name('me');
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
});