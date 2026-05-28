<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('image-upload', [ImageUploadController::class, 'showForm'])->name('image.form')->middleware('auth');
Route::post('image-upload', [ImageUploadController::class, 'upload'])->name('image.upload')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return redirect()->route('character.index');
    // })->name('dashboard');

    Route::resource('character', CharacterController::class);

    Route::get('character/{character}/inventory', [CharacterController::class, 'inventory'])
        ->name('character.inventory');
    Route::post('character/{character}/inventory', [CharacterController::class, 'updateInventoryEquipment'])
        ->name('character.inventory.update');

    Route::get('items', [ItemController::class, 'index'])->name('items.index');

    Route::middleware('admin')->group(function () {
        Route::get('items/deleted', [ItemController::class, 'deleted'])->name('items.deleted');
        Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('items', [ItemController::class, 'store'])->name('items.store');
        Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('items/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::post('items/{id}/restore', [ItemController::class, 'restore'])->name('items.restore');
    });

    Route::get('items/{item}', [ItemController::class, 'show'])
        ->whereNumber('item')
        ->name('items.show');

    Route::get('users', [UserController::class, 'index'])
        ->name('user.index');
});