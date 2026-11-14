<?php

use App\Http\Controllers\FarmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/farm/analyze', [FarmController::class, 'analyze']);