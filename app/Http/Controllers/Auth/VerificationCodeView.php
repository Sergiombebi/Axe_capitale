<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationCodeView extends Controller
{
    public function ShowVerificationForm()
    {
        return view('emails.VerificationCodeMail');
    }
    public function verify(Request $request){

        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|string',
        ]);

        //$user = Auth::user();   //recupere l'utilisateur quthentifier

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé avec cet email.']);
        }

        if ($user->verification_code === $request->verification_code) {
            $user->email_verified_at = now();
            $user->save();

            // return redirect()->route('login.show')->with('status', 'Votre email a ete verifié, vous pouvez maintenant vous connecter.');
            return redirect()->route('welcome')->with('connexion effectuer avec succes');
        }


        return back()->withErrors(['verification_code' => 'Le code de verification est incorrect.']);
    }
}
