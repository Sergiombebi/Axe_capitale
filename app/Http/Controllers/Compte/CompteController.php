<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompteActive;
use App\Mail\CompteDesactive;
use Illuminate\Validation\Rule;
use Symfony\Contracts\Service\Attribute\Required;

class CompteController extends Controller
{
    /**
     * Enregistrement du compte utilisateur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'cni' => [
                'required',
                'string',
                'max:100',
                Rule::unique('comptes')->where(function ($query) use ($request) {
                    return $query
                        ->where('user_id', '!=', Auth::id()); // ignore les CNI du même utilisateur
                }),
            ],
            'photo_cni' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'sexe' => 'required|in:Homme,Femme',
            'telephone' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
            'ville' => 'required|string|max:100',
            'quartier' => 'required|string|max:100',
            'lieudit' => 'nullable|string|max:100',
            'contact_urgence' => 'required|string|max:255',
            'tel_urgence' => 'required|string|max:20',
            'fait_le' => 'required|date',
            'fait_a' => 'required|string|max:255',
        ]);

        // Enregistrer l'image CNI
        $cheminImage = $request->file('photo_cni')->store('cni', 'public');

        // Créer le compte
        $compte = Compte::create([
            'user_id' => Auth::id(),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'cni' => $request->cni,
            'photo_cni' => $cheminImage,
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'pays' => $request->pays,
            'ville' => $request->ville,
            'quartier' => $request->quartier,
            'lieudit' => $request->lieudit,
            'contact_urgence' => $request->contact_urgence,
            'tel_urgence' => $request->tel_urgence,
            'fait_le' => $request->fait_le,
            'fait_a' => $request->fait_a,
            'status' => 'inactif', // Par défaut
        ]);

        return redirect()->back()->with('compte_cree', true);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'telephone' => 'required|string',
            'ville' => 'required|string',
            'quartier' => 'required|string',
            'sexe' => 'required|in:Homme,Femme',
            'pays' => 'required|string',
            'lieudit' => 'nullable|string',
        ]);

        $compte = Compte::findOrFail($id);

        // Sécurité : s’assurer que c’est bien le compte de l’utilisateur connecté
        if ($compte->user_id !== auth()->id()) {
            abort(403);
        }

        $compte->update($request->only([
            'nom',
            'prenom',
            'telephone',
            'ville',
            'quartier',
            'sexe',
            'pays',
            'lieudit'
        ]));

        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
    }
    //gestionnaire de compte il valide les comptes des utilisateur et mets le solde a jour
    //fonction qui retourne le page de tableau de bord

    public function dashboard(Request $request)
    {
        // Vérifier que l'utilisateur est gestionnaire de compte
        // if (auth()->user()->role !== 'gestionnaire_compte') {
        //     return view('dashboard.TableauBord');
        // }

        // Statistiques générales
        $totalComptes = Compte::count();
        $comptesActifs = Compte::where('status', 'actif')->count();
        $comptesInactifs = Compte::where('status', 'inactif')->count();
        $comptesAujourdhui = Compte::whereDate('created_at', Carbon::today())->count();

        // Liste des villes pour le filtre
        $villes = Compte::distinct()->pluck('ville')->filter()->sort()->values();

        // Query de base pour les comptes
        $query = Compte::with('user');

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('cni', 'like', "%{$search}%")
                    ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ville')) {
            $query->where('ville', $request->ville);
        }

        // Pagination des comptes
        $comptes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.TableauBord', compact(
            'totalComptes',
            'comptesActifs',
            'comptesInactifs',
            'comptesAujourdhui',
            'villes',
            'comptes'
        ));
    }

    public function activerCompte($id)
    {
        // Vérifier les permissions
        if (auth()->user()->role !== 'gestionnaire_compte') {
            return response()->json([
                'success' => false,
                'message' => 'Permission refusée'
            ], 403);
        }

        try {
            $compte = Compte::with('user')->findOrFail($id);

            // Vérifier si le compte n'est pas déjà actif
            if ($compte->status === 'actif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le compte est déjà actif'
                ]);
            }

            // Vérifier que l'utilisateur a un email
            if (!$compte->user || !$compte->user->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email de l\'utilisateur introuvable'
                ]);
            }

            $compte->update(['status' => 'actif']);

            // Envoyer l'email d'activation
            try {
                Mail::to($compte->user->email)->send(new CompteActive($compte));
                $emailStatus = 'Email envoyé avec succès';
            } catch (\Exception $mailException) {
                \Illuminate\Support\Facades\Log::error("Erreur envoi email activation", [
                    'compte_id' => $id,
                    'email' => $compte->user->email,
                    'erreur' => $mailException->getMessage()
                ]);
                $emailStatus = 'Compte activé mais erreur envoi email';
            }

            // Log de l'action
            \Illuminate\Support\Facades\Log::info("Compte activé par gestionnaire", [
                'compte_id' => $id,
                'gestionnaire_id' => auth()->id(),
                'gestionnaire_nom' => auth()->user()->name,
                'email_status' => $emailStatus,
                'user_email' => $compte->user->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Compte activé avec succès et email envoyé à ' . $compte->user->email
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Compte introuvable'
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur activation compte", [
                'compte_id' => $id,
                'erreur' => $e->getMessage(),
                'gestionnaire_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'activation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function desactiverCompte(Request $request, $id)
    {
        // Vérifier les permissions
        // if (auth()->user()->role !== 'gestionnaire_compte') {
        //     return response()->json([
        //         'success' => false, 
        //         'message' => 'Permission refusée'
        //     ], 403);
        // }

        try {
            $compte = Compte::with('user')->findOrFail($id);

            // Vérifier si le compte n'est pas déjà inactif
            if ($compte->status === 'inactif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le compte est déjà inactif'
                ]);
            }

            // Vérifier que l'utilisateur a un email
            if (!$compte->user || !$compte->user->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email de l\'utilisateur introuvable'
                ]);
            }

            $compte->update(['status' => 'inactif']);

            // Récupérer la raison de la désactivation si fournie
            $raison = $request->input('raison', 'Suspension temporaire pour vérification');

            // Envoyer l'email de désactivation
            try {
                Mail::to($compte->user->email)->queue(new CompteDesactive($compte, $raison));
                $emailStatus = 'Email envoyé avec succès';
            } catch (\Exception $mailException) {
                \Illuminate\Support\Facades\Log::error("Erreur envoi email désactivation", [
                    'compte_id' => $id,
                    'email' => $compte->user->email,
                    'erreur' => $mailException->getMessage()
                ]);
                $emailStatus = 'Compte désactivé mais erreur envoi email';
            }

            // Log de l'action
            \Illuminate\Support\Facades\Log::info("Compte désactivé par gestionnaire", []);

            return response()->json([
                'success' => true,
                'message' => 'Compte désactivé avec succès et email envoyé à ' . $compte->user->email
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Compte introuvable'
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur désactivation compte", [
                'compte_id' => $id,
                'erreur' => $e->getMessage(),

            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la désactivation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detailsCompte($id)
    {
        $compte = Compte::with('user')->findOrFail($id);
        return view('dashboard.details-compte', compact('compte'));
    }

    public function exportComptes(Request $request)
    {
        $comptes = Compte::with('user')->get();

        $filename = 'comptes_export_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($comptes) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Prénom',
                'Date Naissance',
                'Lieu Naissance',
                'CNI',
                'Sexe',
                'Téléphone',
                'Pays',
                'Ville',
                'Quartier',
                'Contact Urgence',
                'Tel Urgence',
                'Statut',
                'Date Création'
            ]);

            // Données
            foreach ($comptes as $compte) {
                fputcsv($file, [
                    $compte->id,
                    $compte->nom,
                    $compte->prenom,
                    $compte->date_naissance,
                    $compte->lieu_naissance,
                    $compte->cni,
                    $compte->sexe,
                    $compte->telephone,
                    $compte->pays,
                    $compte->ville,
                    $compte->quartier,
                    $compte->contact_urgence,
                    $compte->tel_urgence,
                    $compte->status,
                    $compte->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function storeCompteBloque(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'date_deblocage' => 'required|date|after_or_equal:' . now()->addMonth()->toDateString(),
        ]);

        $user = Auth::user();

        // Récupérer le compte épargne de l'utilisateur
        $compteEpargne = Compte::where('user_id', $user->id)
            ->where('type_compte', 'epargne')
            ->first();

        if (!$compteEpargne) {
            return redirect()->back()->with('error', 'Vous devez d’abord créer un compte épargne.');
        }

        // Créer le compte bloqué en copiant les infos
        Compte::create([
            'user_id'         => $user->id,
            'type_compte'     => 'bloque',
            'solde'           => 0.00,
            'nom'             => $compteEpargne->nom,
            'prenom'          => $compteEpargne->prenom,
            'date_naissance'  => $compteEpargne->date_naissance,
            'lieu_naissance'  => $compteEpargne->lieu_naissance,
            'cni'             => $compteEpargne->cni,
            'photo_cni'       => $compteEpargne->photo_cni,
            'sexe'            => $compteEpargne->sexe,
            'telephone'       => $compteEpargne->telephone,
            'pays'            => $compteEpargne->pays,
            'ville'           => $compteEpargne->ville,
            'quartier'        => $compteEpargne->quartier,
            'lieudit'         => $compteEpargne->lieudit,
            'contact_urgence' => $compteEpargne->contact_urgence,
            'tel_urgence'     => $compteEpargne->tel_urgence,
            'fait_le'         => now()->toDateString(),
            'fait_a'          => $compteEpargne->fait_a,
            'status'          => 'inactif',
            'date_deblocage'  => $request->date_deblocage,
        ]);

        return redirect()->back()->with('success', 'Compte bloqué créé avec succès.');
    }
    public function index()
    {
        $user = Auth::user();
        $compteBloque = Compte::where('user_id', $user->id)
            ->where('type_compte', 'bloque')
            ->first();

        // Créer une variable booléenne plus claire
        $dejaCree = $compteBloque ? true : false;

        return view('dashboard.compte-bloque-terme-collectif', compact('compteBloque', 'dejaCree'));
    }
    public function storeCompteTerme(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'date_deblocage' => 'required|date|after_or_equal:' . now()->addMonths(2)->toDateString(),
        ]);

        $user = Auth::user();

        // Récupérer le compte épargne de l'utilisateur
        $compteEpargne = Compte::where('user_id', $user->id)
            ->where('type_compte', 'epargne')
            ->first();

        if (!$compteEpargne) {
            return redirect()->back()->with('error', 'Vous devez d’abord créer un compte épargne.');
        }

        // Créer le compte à terme en copiant les infos
        Compte::create([
            'user_id'         => $user->id,
            'type_compte'     => 'terme',
            'solde'           => 0.00,
            'nom'             => $compteEpargne->nom,
            'prenom'          => $compteEpargne->prenom,
            'date_naissance'  => $compteEpargne->date_naissance,
            'lieu_naissance'  => $compteEpargne->lieu_naissance,
            'cni'             => $compteEpargne->cni,
            'photo_cni'       => $compteEpargne->photo_cni,
            'sexe'            => $compteEpargne->sexe,
            'telephone'       => $compteEpargne->telephone,
            'pays'            => $compteEpargne->pays,
            'ville'           => $compteEpargne->ville,
            'quartier'        => $compteEpargne->quartier,
            'lieudit'         => $compteEpargne->lieudit,
            'contact_urgence' => $compteEpargne->contact_urgence,
            'tel_urgence'     => $compteEpargne->tel_urgence,
            'fait_le'         => now()->toDateString(),
            'fait_a'          => $compteEpargne->fait_a,
            'status'          => 'inactif',
            'date_deblocage'  => $request->date_deblocage,
        ]);

        return redirect()->back()->with('success', 'Compte à terme créé avec succès.');
    }
    public function updateSolde(Request $request, Compte $compte)
    {
        if ($compte->status != 'actif') {
            return redirect()->back()->with('error', 'Seuls les comptes actifs peuvent être mis à jour.');
        }

        $request->validate([
            'solde' => 'required|numeric|min:0',
        ]);

        $compte->solde = $request->solde;
        $compte->save();

        return redirect()->back()->with('success', 'Solde mis à jour avec succès.');
    }
}
