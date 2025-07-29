<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inscription', [RegisterController::class, 'showForm'])->name('register.form');
Route::get('/connexion',[LoginController::class, 'showFormLogin'])->name('login');
