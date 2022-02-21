<?php

use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\ProductoCarritoController;
use App\Http\Controllers\API\PedidoController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
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

Route::get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::get('/productos/{producto}', [ProductoController::class, 'show']);
Route::get('/productos/tipo/{tipoProducto}', [ProductoController::class, 'getByTipo']);
Route::put('/productos/{producto}', [ProductoController::class, 'update']);
//Route::delete('/productos/{producto}', [ProductoController::class, 'destroy']);

//ProductoCarrito
Route::get('/productoscarritos', [ProductoCarritoController::class, 'index']);
Route::post('/productoscarritos', [ProductoCarritoController::class, 'store']);
Route::get('/productoscarritos/producto/{producto}', [ProductoCarritoController::class, 'getByProducto']);
Route::put('/productoscarritos/{productoCarrito}', [ProductoCarritoController::class, 'update']);
Route::delete('/productoscarritos/{productoCarrito}', [ProductoCarritoController::class, 'destroy']);


//Pedido
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
Route::get('/pedidos/lista/preparacion', [PedidoController::class, 'getPreparacion']);
Route::get('/pedidos/lista/entrega', [PedidoController::class, 'getEntrega']);
Route::get('/pedidos/lista/historial', [PedidoController::class, 'getHistorialPedidoByUsuario']);

//Usuario
Route::put('/user/{user}', [UserController::class, 'update'])->name('update');
Route::get('/user/{user}', [UserController::class, 'show']);
Route::get('/user/rol/{rol}', [UserController::class, 'getUserByRol']);
Route::get('/user/email/{email}', [UserController::class, 'getUserByEmail']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    
});