<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Compte;
use App\Models\Credit;
use App\Models\ImportExport;
use App\Models\FinancementProjet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
    
class DashboardController extends Controller
{
    public function dashboard(Request $request)
{
    if (!Auth::user() || Auth::user()->role !== 'admin') {
        abort(403, 'Accès non autorisé');
    }

    // Statistiques globales
    $totalUtilisateurs = User::count();
    $totalComptes = Compte::count();
    $totalCredits = Credit::count();
    $totalImportExport = ImportExport::count();
    $totalProjets = FinancementProjet::count();
    $montantTotalCredits = Credit::sum('montant');

    // Statistiques par rôle
    $statsRoles = User::select('role', DB::raw('count(*) as total'))
        ->groupBy('role')
        ->pluck('total', 'role')
        ->toArray();

    // Activités récentes RÉELLES (dernières 15 actions)
    $activitesRecentes = collect();

    // Derniers utilisateurs inscrits
    $derniersUtilisateurs = User::latest()
        ->take(3)
        ->get()
        ->map(function($user) {
            return (object)[
                'description' => "Nouvel utilisateur inscrit: {$user->name} ({$user->role})",
                'created_at' => $user->created_at,
                'type' => 'user',
                'icon' => '👤'
            ];
        });

    // Derniers comptes créés
    $derniersComptes = Compte::latest()
        ->take(3)
        ->get()
        ->map(function($compte) {
            return (object)[
                'description' => "Nouveau compte créé: {$compte->nom} {$compte->prenom}",
                'created_at' => $compte->created_at,
                'type' => 'compte',
                'icon' => '💳'
            ];
        });

    // Derniers crédits
    $derniersCredits = Credit::latest()
        ->take(3)
        ->get()
        ->map(function($credit) {
            $montant = number_format($credit->montant, 0, ',', ' ');
            $statut = match($credit->status) {
                'en_attente' => 'demandé',
                'approuve' => 'approuvé',
                'debourse' => 'déboursé',
                'rejete' => 'rejeté',
                default => $credit->status
            };
            return (object)[
                'description' => "Crédit de {$montant} FCFA {$statut}",
                'created_at' => $credit->created_at,
                'type' => 'credit',
                'icon' => '💰'
            ];
        });

    // Dernières demandes import/export
    $dernieresImports = ImportExport::latest()
        ->take(3)
        ->get()
        ->map(function($import) {
            return (object)[
                'description' => "Demande import/export: {$import->nom_marchandise}",
                'created_at' => $import->created_at,
                'type' => 'import',
                'icon' => '🚢'
            ];
        });

    // Derniers projets de financement
    $derniersProjets = FinancementProjet::latest()
        ->take(3)
        ->get()
        ->map(function($projet) {
            return (object)[
                'description' => "Projet soumis: {$projet->nom_projet}",
                'created_at' => $projet->created_at,
                'type' => 'projet',
                'icon' => '🎯'
            ];
        });

    // Fusionner toutes les activités et trier par date
    $activitesRecentes = $derniersUtilisateurs
        ->concat($derniersComptes)
        ->concat($derniersCredits)
        ->concat($dernieresImports)
        ->concat($derniersProjets)
        ->sortByDesc('created_at')
        ->take(15);

    // Liste de tous les utilisateurs avec filtres
    $utilisateurs = User::query()
        ->when($request->search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->when($request->role, function($query, $role) {
            $query->where('role', $role);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    $tousUtilisateurs = User::all();

    return view('admin.dashboard', compact(
        'totalUtilisateurs',
        'totalComptes',
        'totalCredits',
        'totalImportExport',
        'totalProjets',
        'montantTotalCredits',
        'statsRoles',
        'activitesRecentes',
        'utilisateurs',
        'tousUtilisateurs'
    ));
}

    public function storeUser(Request $request)
    {
        // Vérification manuelle du rôle
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,gestionnaire_compte,gestionnaire_credit,gest-import,gest-financement,client'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Utilisateur créé avec succès');
    }

    public function assignRole(Request $request)
    {
        // Vérification manuelle du rôle
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,gestionnaire_compte,gestionnaire_credit,gest-import,gest-financement,client'
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        // Empêcher de modifier son propre rôle
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle');
        }

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Rôle attribué avec succès');
    }

    public function deleteUser($id)
    {
        // Vérification manuelle du rôle
       if (!Auth::user() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $user = User::findOrFail($id);

        // Empêcher de supprimer son propre compte
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas supprimer votre propre compte'
            ], 400);
        }

        // Empêcher de supprimer le dernier admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer le dernier administrateur'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès'
        ]);
    }

    public function exportGlobalReport()
    {
        // Vérification manuelle du rôle
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé');
        }
        
        return redirect()->route('admin.dashboard')
            ->with('info', 'Fonctionnalité d\'export en développement');
    }
}
