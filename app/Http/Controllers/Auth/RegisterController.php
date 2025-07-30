<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use League\Config\Exception\ValidationException;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('register.login');
    }
    public function register(Request $request)
    {
        try {
            // 🔐 Validation
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^[0-9+\s]+$/',
                    'unique:users,phone' // ✅ correction ici
                ],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed'],
            ]);

            // ✅ Définir le code de vérification
            $verification_code = strtoupper(Str::random(6));

            // ✅ Enregistrement en BDD
            // dd($verification_code);
            $user = User::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'], // ✅ correction ici
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'verification_code' => $verification_code,
                'email_verified_at' => null,
                'role' => 'user',
            ]);

            // 🔔 Envoi mail + événement Laravel
            event(new Registered($user));
                 Mail::to($user->email)->send(new VerificationCodeMail($user));
            // 🔓 Connexion automatique
            Auth::login($user);

            return redirect()->route('verify.show')->with([
                'success' => 'Votre compte a été créé. Veuillez vérifier votre email !',
                'email' => $user->email
            ]);
           
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur inscription', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except('password')
            ]);

            return back()->withInput()->with('error', 'Une erreur est survenue.');
        }
    }
}
