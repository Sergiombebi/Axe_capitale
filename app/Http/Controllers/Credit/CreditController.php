<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Credit;
use Illuminate\Container\Attributes\Log;

class CreditController extends Controller
{
    public function credit()
    {
        return view('Credit.credit');
    }
    public function formdemandecredit()
{
    $compte = auth()->user()->compte; // Récupère le compte de l'utilisateur connecté
    return view('Credit.formdemandecredit', compact('compte'));
}

    public function store(Request $request)
{
    //dd($request->all());
    try {
        // ✅ 1. Validation des données du formulaire
        $validated = $request->validate([
            'compte_id' => 'required|exists:comptes,id',
            'montant' => 'required|numeric|min:10000',
            'duree' => 'required|integer|min:1',
            'objet_credit' => 'required|string|max:1000',

            // Avalistes
            'avaliste1_nom' => 'required|string|max:255',
            'avaliste1_telephone' => 'required|string|max:20',
            'avaliste1_cni' => 'required|string|max:50',
            'avaliste2_nom' => 'required|string|max:255',
            'avaliste2_telephone' => 'required|string|max:20',
            'avaliste2_cni' => 'required|string|max:50',

            // Situation
            'statut_professionnel' => 'required|string',
            'situation_familiale' => 'required|string',
            'revenus_mensuels' => 'required|numeric|min:0',
            'personnes_charge' => 'nullable|integer|min:0',

            // Documents (obligatoires)
            'demande_manuscrite' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photocopie_cni' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'plan_localisation' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'justificatifs_financiers' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Garanties
            'garanties' => 'required|string|max:1000',
        ]);

        // ✅ 2. Upload des fichiers
        $paths = [];
        foreach (['demande_manuscrite', 'photocopie_cni', 'plan_localisation', 'justificatifs_financiers'] as $field) {
            if ($request->hasFile($field)) {
                $paths[$field] = $request->file($field)->store("credits/{$field}", 'public');
            }
        }

        // ✅ 3. Création du crédit
        $credit = Credit::create([
            'compte_id' => $validated['compte_id'],
            'montant' => $validated['montant'],
            'duree' => $validated['duree'],
            'objet_credit' => $validated['objet_credit'],

            'avaliste1_nom' => $validated['avaliste1_nom'],
            'avaliste1_telephone' => $validated['avaliste1_telephone'],
            'avaliste1_cni' => $validated['avaliste1_cni'],
            'avaliste2_nom' => $validated['avaliste2_nom'],
            'avaliste2_telephone' => $validated['avaliste2_telephone'],
            'avaliste2_cni' => $validated['avaliste2_cni'],

            'statut_professionnel' => $validated['statut_professionnel'],
            'situation_familiale' => $validated['situation_familiale'],
            'revenus_mensuels' => $validated['revenus_mensuels'],
            'personnes_charge' => $validated['personnes_charge'] ?? 0,

            'demande_manuscrite' => $paths['demande_manuscrite'] ?? null,
            'photocopie_cni' => $paths['photocopie_cni'] ?? null,
            'plan_localisation' => $paths['plan_localisation'] ?? null,
            'justificatifs_financiers' => $paths['justificatifs_financiers'] ?? null,

            'garanties' => $validated['garanties'],
            'status' => Credit::STATUS_EN_ATTENTE,
        ]);

        return back()->with('success', 'Votre demande de crédit a été enregistrée avec succès et est en attente de traitement.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Gestion des erreurs de validation
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        // Gestion des autres erreurs
        \Illuminate\Support\Facades\Log::error('Erreur lors de la création du crédit : ' . $e->getMessage());
        return back()->with('error', 'Une erreur est survenue lors de l’enregistrement de votre demande. Veuillez réessayer.');
    }
}
//fonction qui affiche la vue du tableau de bord gestionnaire de credit
    public function gestionCredit(Request $request)
    {
        // Vérification du rôle
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        $query = Credit::with('compte'); // Relation avec la table comptes

        // Filtres de recherche
        if ($request->search) {
            $query->whereHas('compte', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('cni', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->montant_range) {
            switch ($request->montant_range) {
                case '0-100000':
                    $query->whereBetween('montant', [0, 100000]);
                    break;
                case '100000-500000':
                    $query->whereBetween('montant', [100000, 500000]);
                    break;
                case '500000-1000000':
                    $query->whereBetween('montant', [500000, 1000000]);
                    break;
                case '1000000+':
                    $query->where('montant', '>', 1000000);
                    break;
            }
        }

        $credits = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistiques
        $totalCredits = Credit::count();
        $creditsEnAttente = Credit::where('status', 'en_attente')->count();
        $creditsApprouves = Credit::where('status', 'approuve')->count();
        $creditsEnRetard = Credit::where('status', 'en_retard')->count();
        $montantTotalCredits = Credit::sum('montant');

        return view('tableauDeBord.gestionCredit', compact(
            'credits',
            'totalCredits',
            'creditsEnAttente',
            'creditsApprouves',
            'creditsEnRetard',
            'montantTotalCredits'
        ));
    }
    public function Statuscredit()
{
    // On récupère le compte de l'utilisateur connecté
    $compte = \App\Models\Compte::where('user_id', auth()->id())->first();

    // On récupère le dernier crédit lié à ce compte
    $credit = $compte ? $compte->credits()->latest()->first() : null;

    return view('Credit.credit-status', compact('credit'));
}

}


