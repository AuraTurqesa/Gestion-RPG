<?php

use App\Http\Controllers\InventoryMovementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EquipmentController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // Characters
    Route::get('/characters/{character}/inventory', [CharacterController::class, 'inventory']);
    Route::apiResource('characters', CharacterController::class);

    // Lectura de items
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{item}', [ItemController::class, 'show']);

    // Creación del movimiento
    Route::post('/inventory-movements', [InventoryMovementController::class, 'store']);

    // Consulta del equipo actual de un personaje
    Route::get('/characters/{id}/equipment', [EquipmentController::class, 'index']);

    // Acciones del Admin
    Route::middleware(['admin'])->group(function () {
        // Creación, actualización y borrado de items
        Route::post('/items', [ItemController::class, 'store']);
        Route::put('/items/{item}', [ItemController::class, 'update']);
        Route::patch('/items/{item}', [ItemController::class, 'update']);
        Route::delete('/items/{item}', [ItemController::class, 'destroy']);

        // SoftDelete y restauración
        Route::post('/items/{id}/delete', [ItemController::class, 'destroy']);
        Route::post('/items/{id}/restore', [ItemController::class, 'restore']);
    });
});