<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\MapController;

// الصفحة الرئيسية
Route::view('/', 'index')->name('home');

// صفحة التقييم (عرض الفورم)
Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');

// استقبال بيانات التقييم (الـ POST)
Route::post('/assessment/analyze', [AssessmentController::class, 'analyze'])->name('assessment.analyze');

// عرض النتائج
Route::get('/results', [AssessmentController::class, 'results'])->name('results.index');

// عرض الخريطة
Route::get('/map', [MapController::class, 'index'])->name('map.index');