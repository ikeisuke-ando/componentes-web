<?php

use App\Http\Controllers\StarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stars', [StarController::class, 'index',]);
Route::get('/stars/{sample100}', [StarController::class, 'index',]);
Route::get('/stars/{sample1000}', [StarController::class, 'index',]);
Route::get('/stars/{sampleFull}', [StarController::class, 'index',]);
