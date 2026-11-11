<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'dashboard' : 'login'));

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth', ['register' => false])->name('login');
    Route::view('/registro', 'auth', ['register' => true])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('/registro', [AuthController::class, 'register'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/salir', [AuthController::class, 'logout'])->name('logout');
    Route::get('/panel', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/movimientos', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/movimientos/{id}/editar', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/movimientos/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/movimientos/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});
