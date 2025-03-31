<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;    
use App\Http\Controllers\SalaController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;

Route::get('/' , function (){
    return redirect()->route('inicio.index');
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.store');

Route::prefix('inicio')->middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('inicio.index');
});
Route::prefix('reservas')->middleware('auth')->group(function () {
    Route::get('/', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/crear', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/crear', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/editar/{id}', [ReservaController::class, 'edit'])->name('reserva.edit');
    Route::put('/update/{id}', [ReservaController::class, 'update'])->name('reservas.update');
    Route::delete('/eliminar/{id}', [ReservaController::class, 'destroy'])->name('reservas.eliminar');
});

Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/eliminar/{id}', [UserController::class, 'destroy'])->name('users.eliminar');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
})->middleware('auth');

Route::prefix('salas')->middleware('auth')->group(function () {
    Route::get('/', [SalaController::class, 'index'])->name('salas.index');
    Route::get('/create', [SalaController::class, 'create'])->name('salas.create');
    Route::post('/create', [SalaController::class, 'store'])->name('salas.store');
    Route::get('/edit/{id}', [SalaController::class, 'edit'])->name('salas.edit');
    Route::delete('/eliminar/{id}', [SalaController::class, 'destroy'])->name('salas.eliminar');
    Route::put('/update/{id}', [SalaController::class, 'update'])->name('salas.update');
})->middleware('auth');

