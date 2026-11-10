<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceController;
Route::get('/',fn()=>redirect(auth()->check()?'/panel':'/login'));
Route::middleware('guest')->group(function() {
    Route::view('/login','auth',['register'=>false])->name('login');
    Route::view('/registro','auth',['register'=>true])->name('register');
    Route::post('/login',[FinanceController::class,'login'])->middleware('throttle:6,1');
    Route::post('/registro',[FinanceController::class,'register'])->middleware('throttle:6,1');
});
Route::middleware('auth')->group(function() {
    Route::post('/salir',[FinanceController::class,'logout']);
    Route::get('/panel',[FinanceController::class,'index'])->name('dashboard');
    Route::post('/categorias',[FinanceController::class,'category']);
    Route::post('/movimientos',[FinanceController::class,'store']);
    Route::get('/movimientos/{id}/editar',[FinanceController::class,'edit']);
    Route::put('/movimientos/{id}',[FinanceController::class,'update']);
    Route::delete('/movimientos/{id}',[FinanceController::class,'destroy']);
});
