<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationController;

Route::middleware('throttle:api')->group(function () {
    Route::get('/courses', [CourseController::class, 'get']);
    Route::post('/applications', [ApplicationController::class, 'store']);
    Route::delete('/applications', [ApplicationController::class, 'delete']);
    Route::get('/applications', [ApplicationController::class, 'get']);
});
