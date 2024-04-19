<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('deals', DealController::class);

    Route::get('/interests', [InterestController::class, 'index']);
    Route::post('/interests', [InterestController::class, 'store']);
    Route::delete('/interests/{interest}', [InterestController::class, 'destroy']);

    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

    Route::get('/locations', [LocationController::class, 'index']);
    Route::post('/locations', [LocationController::class, 'store']);
    Route::delete('/locations/{location}', [LocationController::class, 'destroy']);

});
