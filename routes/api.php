<?php

use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/category' , [CategoryController::class, 'index']);
Route::post('/category_create' , [CategoryController::class , 'store']);
Route::put('/category_update/{id}' , [CategoryController::class , 'update']);
Route::delete('/category_delete/{id}' , [CategoryController::class , 'destroy']);