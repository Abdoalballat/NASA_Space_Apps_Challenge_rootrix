<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\FarmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/analyze', [AssessmentController::class, 'analyze'])->name('api.assessment.analyze');