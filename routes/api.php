<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('contacts', ContactController::class)->middleware('auth:sanctum');
Route::apiResource('deals', DealController::class)->middleware('auth:sanctum');