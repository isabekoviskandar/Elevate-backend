<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category_create', [CategoryController::class, 'store']);
Route::put('/category_update/{id}', [CategoryController::class, 'update']);
Route::delete('/category_delete/{id}', [CategoryController::class, 'destroy']);


Route::get('/project', [ProjectController::class, 'index']);
Route::post('/project_create', [ProjectController::class, 'store']);
Route::put('/project_update/{id}', [ProjectController::class, 'update']);
Route::delete('/project_delete/{id}', [ProjectController::class, 'destroy']);


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout']);

