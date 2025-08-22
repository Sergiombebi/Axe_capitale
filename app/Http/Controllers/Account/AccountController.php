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
    $bloqueExiste = $compteBloque !== null;
    
    // Récupérer SPÉCIFIQUEMENT le compte à terme
    $compteTerme = Compte::where('user_id', $user->id)
        ->where('type_compte', 'terme')
        ->first();
    $termeExiste = $compteTerme !== null;
   
    return view('dashboard.CreateAccount', compact(
        'dejaCree',        // Boolean : compte principal existe ?
        'compte',          // Objet : données du compte principal
        'compteBloque',    // Objet : données du compte bloqué (ou null)
        'bloqueExiste',    // Boolean : compte bloqué existe ?
        'compteTerme',     // Objet : données du compte à terme (ou null)
        'termeExiste'      // Boolean : compte à terme existe ?
    ));
}

}
