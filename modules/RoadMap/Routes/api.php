<?php

use Illuminate\Support\Facades\Route;
use Modules\RoadMap\Controllers\PersonalPreferenceController;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('personal-preference', PersonalPreferenceController::class);
});

