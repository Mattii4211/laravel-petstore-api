<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/', [PetController::class, 'index']);
Route::get('/pets', [PetController::class, 'index']);
Route::get('/pets/create', [PetController::class, 'create']);
Route::post('/pets', [PetController::class, 'store']);
Route::get('/pets/{id}/edit', [PetController::class, 'edit']);
Route::put('/pets/{id}', [PetController::class, 'update']);
Route::delete('/pets/{id}', [PetController::class, 'destroy']);