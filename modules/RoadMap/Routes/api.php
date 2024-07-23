<?php

use Illuminate\Support\Facades\Route;
use Modules\RoadMap\Controllers\CareerController;
use Modules\RoadMap\Controllers\CourseController;
use Modules\RoadMap\Controllers\ExamController;
use Modules\RoadMap\Controllers\PersonalPreferenceController;
use Modules\RoadMap\Controllers\ProfileContoller;
use Modules\RoadMap\Controllers\SuggestionContoller;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('personal-preference', PersonalPreferenceController::class)->except('update');
    Route::put('personal-preference/{personal_preference?}', [PersonalPreferenceController::class, 'update'])->name('personal-preference.update');
    Route::apiResource('careers', CareerController::class)->only(['index']);
    Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
    Route::apiResource('exams', ExamController::class)->only(['store', 'update']);
    Route::get('suggestions', [SuggestionContoller::class, 'show'])->name('suggestions.show');
    Route::get('profiles', [ProfileContoller::class, 'show'])->name('profile.show');
});

