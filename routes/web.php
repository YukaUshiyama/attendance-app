<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('user.register');
});
Route::post('/register', [UserController::class, 'store']);
Route::get('/login', function () {
    return view('user.user-login');
})->name('login');
Route::get('/attendance', [AttendanceController::class, 'index'])
    ->middleware('auth');
Route::post('/attendance', [AttendanceController::class, 'store'])
    ->middleware('auth');