<?php

use Modules\Authentication\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('register');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function(){
    Route::get('test-auth', function(){
        return ['message' => 'done'];
    })->name('test-auth');
});

