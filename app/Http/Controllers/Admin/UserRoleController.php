<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Afficher la page protégée listant les utilisateurs
     */
    public function index(Request $request)
    {
        // 🔐 Mot de passe d’accès (on le mettra ensuite dans .env)
        $motDePasseAdmin = env('ADMIN_PAGE_PASSWORD', 'secure@123');

        // Vérification du mot de passe soumis
        if ($request->isMethod('post')) {
            if ($request->input('password') === $motDePasseAdmin) {
                session(['admin_access' => true]);
            } else {
                return back()->with('error', 'Mot de passe incorrect.');
            }
        }

        // Si pas encore connecté
        if (!session('admin_access')) {
            return view('admin.password_protect');
        }

        // Récupération de tous les utilisateurs
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    /**
     * Mettre à jour le rôle d’un utilisateur
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return back()->with('success', "Le rôle de {$user->name} a été mis à jour !");
    }

    /**
     * Réinitialiser l’accès admin
     */
    public function logoutAccess()
    {
        session()->forget('admin_access');
        return redirect()->route('admin.users');
    }
}
