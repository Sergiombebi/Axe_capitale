<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Mail\VerificationCodeMail;
use App\Http\Controllers\Auth\VerificationCodeView;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Compte\CompteController;

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

//route pour la connexion
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
//deconnexio
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
//route pour la page de creation de compte
Route::get('/create-account', [AccountController::class, 'index'])->name('create.account');

Route::post('/compte/store', [CompteController::class, 'store'])->middleware('auth')->name('compte.store');
Route::put('/compte/{id}', [CompteController::class, 'update'])->name('compte.update');
// route pour le tableau de bord
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', [CompteController::class, 'dashboard'])->name('dashboard');
    
    // Routes spécifiques au gestionnaire de comptes
    Route::prefix('gestionnaire')->name('gestionnaire.')->group(function () {
        
        // Activation/Désactivation des comptes
        Route::post('/comptes/{id}/activer', [CompteController::class, 'activerCompte'])->name('comptes.activer');
        Route::post('/comptes/{id}/desactiver', [CompteController::class, 'desactiverCompte'])->name('comptes.desactiver');
        
        // Détails d'un compte
        Route::get('/comptes/{id}/details', [CompteController::class, 'detailsCompte'])->name('comptes.details');
        
        // Export des données
        Route::get('/comptes/export', [CompteController::class, 'exportComptes'])->name('comptes.export');
    });
    Route::post('/compte/bloque/store', [CompteController::class, 'storeCompteBloque'])
     ->name('compte.bloque.store');
     Route::post('/compte/terme/store', [CompteController::class, 'storeCompteTerme'])
     ->name('compte.terme.store');
});

