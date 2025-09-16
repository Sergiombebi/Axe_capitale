<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Credit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
\Illuminate\Support\Facades\DB::commit();
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Remboursement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
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
            $query->whereHas('compte', function ($q) use ($request) {
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
   public function traiter(Credit $credit)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        if ($credit->status !== 'en_attente') {
            return redirect()->route('gestionnaire.credits.index')
                ->with('error', 'Ce crédit ne peut plus être traité');
        }

        return view('Credit.traiter', compact('credit'));
    }
    /**
     * Traitement POST du crédit
     */
    public function traiterPost(Request $request, Credit $credit)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'decision' => 'required|in:approuve,rejete,en_etude',
            'motif_rejet' => 'required_if:decision,rejete',
            'observations' => 'nullable|string|max:1000'
        ]);

        $credit->update([
            'status' => $request->decision,
            'motif_rejet' => $request->decision === 'rejete' ? $request->motif_rejet : null,
            'observations' => $request->observations,
            'date_traitement' => now(),
            'traite_par' => auth()->id()
        ]);

        $message = match($request->decision) {
            'approuve' => 'Crédit approuvé avec succès',
            'rejete' => 'Crédit rejeté',
            'en_etude' => 'Crédit mis en étude'
        };

        return redirect()->route('credit.dashboard')
            ->with('success', $message);
    }
    /**
     * Débourser un crédit
     */
    public function debourser(Credit $credit)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        if (!in_array($credit->status, ['approuve'])) {
            return redirect()->route('gestionnaire.credits.index')
                ->with('error', 'Ce crédit ne peut pas être déboursé');
        }

        $credit->update([
            'status' => 'debourse',
            'date_debours' => now(),
            'debourse_par' => auth()->id()
        ]);

        return redirect()->route('credit.dashboard')
            ->with('success', 'Crédit déboursé avec succès');
    }

    /**
     * Page de remboursement
     */
    public function rembourser(Credit $credit)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        if (!in_array($credit->status, ['debourse', 'en_remboursement', 'en_retard'])) {
            return redirect()->route('gestionnaire.credits.index')
                ->with('error', 'Ce crédit ne peut pas être remboursé');
        }

        return view('Credit.rembourser', compact('credit'));
    }
    /**
     * Enregistrer un remboursement
     */
    public function rembourserPost(Request $request, Credit $credit)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'montant' => 'required|numeric|min:1',
            'type' => 'required|in:partiel,total,echeance',
            'notes' => 'nullable|string|max:500'
        ]);

        // Vérifier que le montant ne dépasse pas le solde restant
        $soldeRestant = $credit->montant_total_rembourser - $credit->montant_rembourse;
        if ($request->montant > $soldeRestant) {
            return back()->with('error', 'Le montant ne peut pas dépasser le solde restant: ' . number_format($soldeRestant, 0, ',', ' ') . ' FCFA');
        }

        // Enregistrer le remboursement
        Remboursement::create([
            'credit_id' => $credit->id,
            'montant' => $request->montant,
            'type' => $request->type,
            'notes' => $request->notes,
            'date_remboursement' => now(),
            'enregistre_par' => auth()->id()
        ]);

        // Mettre à jour le crédit
        $nouveauMontantRembourse = $credit->montant_rembourse + $request->montant;
        $nouveauSolde = $credit->montant_total_rembourser - $nouveauMontantRembourse;

        $credit->update([
            'montant_rembourse' => $nouveauMontantRembourse,
            'solde_restant' => $nouveauSolde,
            'status' => $nouveauSolde <= 0 ? 'rembourse' : 'en_remboursement',
            'date_dernier_remboursement' => now()
        ]);

        if ($request->type === 'echeance') {
            $credit->increment('echeances_payees');
        }

        return redirect()->route('credit.dashboard')
            ->with('success', 'Remboursement enregistré avec succès');
    }
    /**
     * Détails d'un crédit
     */
    public function details(Credit $credit)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        $credit->load('compte', 'remboursements');
        
        return view('Credit.detail', compact('credit'));
    }
    /**
     * Afficher/télécharger un document
     */
    public function document(Credit $credit, $type)
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        $allowedTypes = [
            'demande_manuscrite',
            'photocopie_cni',
            'plan_localisation',
            'justificatifs_financiers'
        ];

        if (!in_array($type, $allowedTypes)) {
            abort(404, 'Type de document non valide');
        }

        $filePath = $credit->$type;
        
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'Document non trouvé');
        }

        $fullPath = Storage::disk('public')->path($filePath);
        $fileName = basename($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);

        return Response::file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }

    /**
     * Exporter les crédits
     */
    public function export()
    {
        if (auth()->user()->role !== 'gestionnaire_credit') {
            abort(403, 'Accès non autorisé');
        }

        $credits = Credit::with('compte')->get();
        
        $filename = 'credits_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($credits) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Client',
                'CNI',
                'Téléphone',
                'Montant',
                'Durée (mois)',
                'Taux (%)',
                'Montant total',
                'Montant mensuel',
                'Objet',
                'Statut',
                'Date création',
                'Date traitement'
            ], ';');

            // Données
            foreach ($credits as $credit) {
                fputcsv($file, [
                    $credit->id,
                    ($credit->compte->nom ?? '') . ' ' . ($credit->compte->prenom ?? ''),
                    $credit->compte->cni ?? '',
                    $credit->compte->telephone ?? '',
                    $credit->montant,
                    $credit->duree,
                    $credit->taux_interet,
                    $credit->montant_total_rembourser,
                    $credit->montant_mensuel,
                    $credit->objet_credit,
                    $credit->status,
                    $credit->created_at->format('d/m/Y H:i'),
                    $credit->date_traitement ? Carbon::parse($credit->date_traitement)->format('d/m/Y H:i') : ''
                ], ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
