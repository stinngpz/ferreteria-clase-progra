<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\EmpleadoController;
use App\Http\Controllers\API\RecursosHumanosController;
//librerias
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::apiResource('producto', ProductoController::class);

//Route::apiResource('empleado', EmpleadoController::class);

Route::apiResource('recursos-humanos', RecursosHumanosController::class)->parameters(['recursos-humanos' => 'id']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('productos', ProductoController::class)->names('api.productos');
});