<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compte;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccountController extends Controller
{
  public function index()
{
    $user = Auth::user();
    
    // Récupérer le compte principal (comme actuellement)
    $compte = Compte::where('user_id', $user->id)->first();
    $dejaCree = $compte !== null;
    
    // Récupérer SPÉCIFIQUEMENT le compte bloqué
    $compteBloque = Compte::where('user_id', $user->id)
        ->where('type_compte', 'bloque')
        ->first();
    
    // Variable pour vérifier si le compte bloqué existe
    $bloqueExiste = $compteBloque !== null;
    
    return view('dashboard.CreateAccount', compact(
        'dejaCree',       // Pour le compte principal
        'compte',         // Données du compte principal
        'compteBloque',   // Données du compte bloqué (null si n'existe pas)
        'bloqueExiste'    // Boolean pour vérifier l'existence du compte bloqué
    ));
}

}
