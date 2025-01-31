<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::get('/contact', [ContactController::class, 'contact']);
Route::post('/contact/confirm', [ContactController::class, 'confirm']);
Route::post('/confirm', [ContactController::class, 'store']);
Route::get('/admin', [ContactController::class, 'admin']);
Route::get('/admin/search', [ContactController::class, 'search']);
Route::get('/admin/details/{id}', [ContactController::class, 'detail']);
Route::post('/admin/delete/{id}', [ContactController::class, 'delete']);
Route::middleware('auth')->group(function(){
    Route::get('/', [AuthController::class, 'index']);
});


