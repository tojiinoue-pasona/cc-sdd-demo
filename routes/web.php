<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/todos'));

Route::get('/todos', [TodoController::class, 'index']);
Route::get('/todos/create', [TodoController::class, 'create']);
Route::post('/todos', [TodoController::class, 'store']);
Route::patch('/todos/{id}/status', [TodoController::class, 'updateStatus']);
Route::delete('/todos/{id}', [TodoController::class, 'destroy']);
