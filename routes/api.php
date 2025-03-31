<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaController;
Route::post('salas/store' , [SalaController::class , 'store']);
Route::put('/salas/{id}', [SalaController::class, 'update']);