<?php

use App\Http\Controllers\TaskController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(TokenVerificationMiddleware::class)->prefix('/task')->group(function () {
    Route::get('/all', [TaskController::class, 'allTask'])->name('all-task');
    Route::post('/add', [TaskController::class, 'addTask'])->name('add-task');
    Route::post('/update/{id}', [TaskController::class, 'updateTask'])->name('update-task');
    Route::post('/delete/{id}', [TaskController::class, 'deleteTask'])->name('delete-task');
});
