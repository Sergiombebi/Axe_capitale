<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showFormLogin()
    {
        return view('register.connexion');
    }
   public function login(Request $request)
{
    try {
        // Validation des données
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Vérification de l'existence de l'utilisateur
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withInput($request->only('email'))
                        ->with('error', 'Aucun compte trouvé avec cette adresse email.');
        }

        // Authentification MANUELLE (remplacement de attempt())
        $remember = $request->boolean('remember');
        
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // CONNEXION EXPLICITE
            Auth::login($user, $remember);
            $request->session()->regenerate();
            
            // Vérification email
            if (!$user->email_verified_at) {
                Auth::logout();
                return redirect()->route('verify.show')
                    ->with([
                        'error' => 'Veuillez vérifier votre email avant de vous connecter.',
                        'email' => $user->email
                    ]);
            }
            
            return redirect()->intended(route('welcome'))
                ->with('success', 'Connexion réussie ! Bienvenue ' . $user->name);
                
        } else {
            return back()->withInput($request->only('email'))
                        ->with('error', 'Email ou mot de passe incorrect.');
        }
        
    } catch (ValidationException $e) {
        // Gestion spécifique des erreurs de validation
        //return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Erreur lors de la connexion', [
            'error' => $e->getMessage(),
            'exception' => get_class($e),
            'trace' => $e->getTraceAsString(),
            'input' => $request->except('password')
        ]);
        
        return back()->withInput($request->only('email'))
                    ->with('error', 'Une erreur technique est survenue. Veuillez réessayer.');
    }
}

    /**
     * 🚪 Méthode de déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')
            ->with('success', 'Déconnexion effectuée avec succès.');
    }
}
