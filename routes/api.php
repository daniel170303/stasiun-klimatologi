<?php

use App\Http\Controllers\Api\DateAvailabilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API untuk cek ketersediaan tanggal
Route::get('/dates/occupied', [DateAvailabilityController::class, 'getOccupiedDates']);
Route::post('/dates/check', [DateAvailabilityController::class, 'checkDate']);