<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('user.register');
});
Route::post('/register', [UserController::class, 'store']);
Route::get('/login', function () {
    return view('user.user-login');
});
Route::get('/attendance', function () {
    return view('user.attendance-register');
});