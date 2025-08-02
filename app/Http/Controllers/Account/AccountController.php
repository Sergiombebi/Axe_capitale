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
    $compte = Compte::where('user_id', $user->id)->first();
    $dejaCree = $compte !== null;

    return view('dashboard.CreateAccount', compact('dejaCree', 'compte'));
}

}
