<?php

use App\Http\Controllers\EscalaController;
use App\Http\Controllers\MinisterController;
use App\Http\Controllers\BackingVocalController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ScaleController;
use App\Http\Controllers\WppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('api.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('api.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('api.profile.destroy');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('user', UserController::class);
Route::apiResource('music', MusicController::class);
Route::apiResource('scale', ScaleController::class);
Route::apiResource('minister', MinisterController::class);
Route::apiResource('backing-vocal', BackingVocalController::class);
Route::post('/add-participant', [WppController::class, 'addParticipant']);
Route::post('/send-text', [WppController::class, 'sendText']);
Route::post('/check-escala', [EscalaController::class, 'checkEscala']);
