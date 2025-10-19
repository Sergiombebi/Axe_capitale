<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Mail\VerificationCodeMail;
use App\Http\Controllers\Auth\VerificationCodeView;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Compte\CompteController;
use App\Http\Controllers\Credit\CreditController;
use App\Http\Controllers\FinancementProjet\FinancementProjetController;
use App\Http\Controllers\Import\ImportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PasswordResetController;
// ✅ Ajouter un nom à la route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/inscription', [RegisterController::class, 'showForm'])->name('register.form');
Route::get('/connexion', [LoginController::class, 'showFormLogin'])->name('login');


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
//mot de passe oublier
Route::get('/password-reset/request', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password-reset/send-link', [PasswordResetController::class, 'sendResetLink'])->name('password.send-link');
Route::get('/password-reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset.show');
Route::post('/password-reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset');




Route::post('/compte/store', [CompteController::class, 'store'])->middleware('auth')->name('compte.store');
Route::put('/compte/{id}', [CompteController::class, 'update'])->name('compte.update');
// route pour le tableau de bord
Route::middleware(['auth'])->group(function () {
    //route pour la page de creation de compte
    Route::get('/create-account', [AccountController::class, 'index'])->name('create.account');

    // Dashboard principal
    Route::get('/GestCompte', [CompteController::class, 'dashboardCompte'])->name('dashboardCompte');

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
    Route::patch('/comptes/{compte}/update-solde', [CompteController::class, 'updateSolde'])->name('comptes.updateSolde');


    //credit
    Route::get('/credit', [CreditController::class, 'credit'])->name('credit');
    Route::get('/credit/versement', [CreditController::class, 'formdemandecredit'])->name('credit.form');
    Route::post('/credits', [CreditController::class, 'store'])->name('credits.store');
    Route::get('/gestioncredit', [CreditController::class, 'gestionCredit'])->name(('credit.dashboard'));
    Route::get('/statuscredit', [CreditController::class, 'Statuscredit'])->name(('credit.status'));
    Route::middleware(['auth'])->prefix('gestionnaire')->name('gestionnaire.')->group(function () {
        Route::get('/credits', [CreditController::class, 'index'])->name('credits.index');
        Route::get('/credits/export', [CreditController::class, 'export'])->name('credits.export');
        Route::get('/credits/{credit}/traiter', [CreditController::class, 'traiter'])->name('credits.traiter');
        Route::post('/credits/{credit}/traiter', [CreditController::class, 'traiterPost'])->name('credits.traiter.post');
        Route::get('/credits/{credit}/debourser', [CreditController::class, 'debourser'])->name('credits.debourser');
        Route::get('/credits/{credit}/rembourser', [CreditController::class, 'rembourser'])->name('credits.rembourser');
        Route::post('/credits/{credit}/rembourser', [CreditController::class, 'rembourserPost'])->name('credits.rembourser.post');
        Route::get('/credits/{credit}/details', [CreditController::class, 'details'])->name('credits.details');
        Route::get('/credits/{credit}/document/{type}', [CreditController::class, 'document'])->name('credits.document');
    });

    //financement de projet
    Route::get('/financement', [FinancementProjetController::class, 'financement'])->name('financement');
    Route::post('/projet/demande', [FinancementProjetController::class, 'store'])->name('projet.store');
    Route::get('/projet/{financementProjet}/success', [FinancementProjetController::class, 'success'])->name('projet.success');
    Route::get('/projet/status', [FinancementProjetController::class, 'status'])->name('projet.status');
    Route::get('/projet/dashboard', [FinancementProjetController::class, 'dashboard'])->name('projet.dashboard');
    Route::get('/details/{projet}', [FinancementProjetController::class, 'details'])->name('details');
    Route::get('/confirmer-paiement/{projet}', [FinancementProjetController::class, 'confirmerPaiement'])->name('confirmer_paiement');
    Route::post('/confirmer-paiement/{projet}', [FinancementProjetController::class, 'validerPaiement'])->name('valider_paiement');
    Route::get('/etudier/{projet}', [FinancementProjetController::class, 'etudier'])->name('etudier');
    Route::post('/etudier/{projet}', [FinancementProjetController::class, 'marquerEnEtude'])->name('marquer_en_etude');
    Route::get('/evaluer/{projet}', [FinancementProjetController::class, 'evaluer'])->name('evaluer');
    Route::post('/evaluer/{projet}', [FinancementProjetController::class, 'prendreDecision'])->name('prendre_decision');
    Route::get('/financer/{projet}', [FinancementProjetController::class, 'financer'])->name('financer');
    Route::post('/financer/{projet}', [FinancementProjetController::class, 'accorderFinancement'])->name('accorder_financement');
    Route::get('/suivi/{projet}', [FinancementProjetController::class, 'suivi'])->name('suivie');
    Route::post('/suivi/{projet}', [FinancementProjetController::class, 'mettreAJourSuivi'])->name('mettre_a_jour_suivi');
    Route::get('/details/{projet}', [FinancementProjetController::class, 'details'])->name('detailes');
    Route::get('/export', [FinancementProjetController::class, 'export'])->name('export');
    Route::get('/rapport/{projet}', [FinancementProjetController::class, 'genererRapport'])->name('generer_rapport');


    //importation et exportation 
    Route::get('/import-export', [ImportController::class, 'index'])->name('import.export');
    Route::post('/import-export/demande', [ImportController::class, 'store'])->name('import.export.store');
    Route::get('/{importExport}/success', [ImportController::class, 'success'])->name('success');
    Route::get('/status', [ImportController::class, 'status'])->name('status');
    Route::get('/dashboard-import', [ImportController::class, 'dashboard'])->name('dashboard.import');

    //
    Route::get('/{demande}/traiter', [ImportController::class, 'traiter'])->name('traiter');
    Route::post('/{demande}/traiter', [ImportController::class, 'traiterPost'])->name('traiter.post');

    // Gestion des devis
    Route::get('/{demande}/devis', [ImportController::class, 'devis'])->name('devis');
    Route::post('/{demande}/devis', [ImportController::class, 'devisPost'])->name('devis.post');

    // Gestion des achats
    Route::get('/{demande}/achat', [ImportController::class, 'achat'])->name('achat');
    Route::post('/{demande}/achat', [ImportController::class, 'achatPost'])->name('achat.post');

    // Suivi d'expédition
    Route::get('/{demande}/suivi', [ImportController::class, 'suivi'])->name('suivi');
    Route::post('/{demande}/suivi', [ImportController::class, 'suiviPost'])->name('suivi.post');

    // Gestion douane et livraison
    Route::get('/{demande}/douane', [ImportController::class, 'douane'])->name('douane');
    Route::post('/{demande}/douane', [ImportController::class, 'douanePost'])->name('douane.post');

    // Détails et photos
    Route::get('/{demande}/details', [ImportController::class, 'details'])->name('details');
    Route::get('/{demande}/photo/{index}', [ImportController::class, 'photo'])->name('photo');
    Route::get('/{importExport}/confirm', [ImportController::class, 'confirmDevis'])->name('confirm');
    Route::post('/{importExport}/confirm', [ImportController::class, 'confirmDevisPost'])->name('confirm.post');
    Route::get('/{importExport}/reject', [ImportController::class, 'rejectDevis'])->name('rejecter');
    Route::post('/{importExport}/reject', [ImportController::class, 'rejectDevisPost'])->name('reject.post');

    // route pour le tableau de bord admin


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
    Route::post('/users/assign-role', [DashboardController::class, 'assignRole'])->name('users.assign-role');
    Route::delete('/users/{id}', [DashboardController::class, 'deleteUser'])->name('users.delete');
    Route::get('/export/global-report', [DashboardController::class, 'exportGlobalReport'])->name('export.global');
    // Routes de réinitialisation de mot de passe (PUBLIC - pas d'authentification requise)


    // Afficher le formulaire de demande de réinitialisation






});
