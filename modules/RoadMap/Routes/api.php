<?php

use Illuminate\Support\Facades\Route;
use Modules\RoadMap\Controllers\CareerController;
use Modules\RoadMap\Controllers\ExamController;
use Modules\RoadMap\Controllers\PersonalPreferenceController;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('personal-preference', PersonalPreferenceController::class)->except('update');
    Route::put('personal-preference/{personal_preference?}', [PersonalPreferenceController::class, 'update'])->name('personal-preference.update');
    Route::apiResource('careers', CareerController::class)->only(['index']);
    Route::apiResource('exams', ExamController::class)->only(['store', 'update']);
});

