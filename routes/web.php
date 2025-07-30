<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Mail\VerificationCodeMail;
use App\Http\Controllers\Auth\VerificationCodeView;

// ✅ Ajouter un nom à la route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/inscription', [RegisterController::class, 'showForm'])->name('register.form');
Route::get('/connexion',[LoginController::class, 'showFormLogin'])->name('login');


Route::post('/register', [RegisterController::class, 'register'])->name('register');
//page d'acceuil


Route::get('verify-mail', [VerificationCodeMail::class, 'ShowVerificationcodeForm'])->name('verify.mail');

Route::get('/verify-show', [VerificationCodeView::class, 'ShowVerificationForm'])->name('verify.show');
Route::post('/verify-show2', [VerificationCodeView::class, 'verify'])->name('verify.show2');