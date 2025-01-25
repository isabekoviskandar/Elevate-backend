<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvestorController;
use App\Livewire\CategoryComponent;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::get('/' , CategoryComponent::class);