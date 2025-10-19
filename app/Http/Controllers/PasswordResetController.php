<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException; 


class PasswordResetController extends Controller
{
    

    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showRequestForm()
    {
        return view('register.password-reset-request');
    }


    /**
     * Traiter la demande de réinitialisation (envoi du lien)
     */
    public function sendResetLink(Request $request)
    {
        try {
            // Validation de l'email
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ], [
                'email.required' => 'L\'adresse email est requise.',
                'email.email' => 'Veuillez entrer une adresse email valide.',
            ]);

            $email = $request->input('email');

            // Vérifier si l'utilisateur existe
            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()->with('error', 'Aucun compte trouvé avec cette adresse email.')
                    ->withInput($request->only('email'));
            }

            // Générer un token unique
            $token = Str::random(64);

            // Supprimer les anciens tokens pour cet email
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            // Insérer le nouveau token
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]);

            // Envoyer l'email avec le lien de réinitialisation
            $resetUrl = route('password.reset.show', ['token' => $token, 'email' => $email]);

            Mail::send('emails.password-reset', [
                'user' => $user,
                'resetUrl' => $resetUrl,
                'expiresIn' => '60 minutes',
            ], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Réinitialisation de votre mot de passe');
            });

            return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email. Veuillez vérifier votre boîte de réception.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de l\'envoi du lien de réinitialisation', [
                'error' => $e->getMessage(),
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString(),
                'email' => $request->input('email')
            ]);

            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.')
                ->withInput($request->only('email'));
        }
    }

    /**
     * Afficher le formulaire de réinitialisation du mot de passe
     */
   public function showResetForm(Request $request)
{
    $token = $request->query('token');
    $email = $request->query('email');

    if (!$token || !$email) {
        return redirect()->route('login')
            ->with('error', 'Lien de réinitialisation invalide.');
    }

    // Vérifier que le token existe et n'a pas expiré (60 minutes)
    $passwordReset = DB::table('password_reset_tokens')
        ->where('email', $email)
        ->where('token', $token) // correspondance directe
        ->first();

    if (!$passwordReset) {
        return redirect()->route('login')
            ->with('error', 'Ce lien de réinitialisation est invalide ou a expiré.');
    }

    // Vérifier l'expiration (60 minutes)
    if (now()->diffInMinutes($passwordReset->created_at) > 60) {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        return redirect()->route('login')
            ->with('error', 'Ce lien de réinitialisation a expiré. Veuillez en demander un nouveau.');
    }

    return view('register.password-reset-reset', [
        'token' => $token,
        'email' => $email,
    ]);
}


    /**
     * Traiter la réinitialisation du mot de passe
     */
    public function resetPassword(Request $request)
{
    try {
        // Validation des données
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ], [
            'password.required' => 'Le mot de passe est requis.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'email.required' => 'L\'adresse email est requise.',
        ]);

        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');

        // Vérifier que l'utilisateur existe
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->with('error', 'Aucun compte trouvé avec cette adresse email.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Vérifier que le token existe et correspond
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            return back()->with('error', 'Le lien de réinitialisation est invalide ou a expiré.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Vérifier l'expiration (60 minutes)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->with('error', 'Ce lien de réinitialisation a expiré. Veuillez en demander un nouveau.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($password),
        ]);

        // Supprimer le token utilisé
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')
            ->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.');

    } catch (ValidationException $e) {
        return back()->withErrors($e->errors())->withInput($request->except('password', 'password_confirmation'));
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Erreur lors de la réinitialisation du mot de passe', [
            'error' => $e->getMessage(),
            'exception' => get_class($e),
            'trace' => $e->getTraceAsString(),
            'email' => $request->input('email')
        ]);

        return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.')
            ->withInput($request->except('password', 'password_confirmation'));
    }
}

}
