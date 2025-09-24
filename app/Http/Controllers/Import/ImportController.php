<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ImportExport;
use App\Models\Compte;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('import.index');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'nom_marchandise' => 'required|string|max:255',
            'categorie' => 'required|in:electronique,vetements,chaussures,maroquinerie,bijoux,cosmetique,jouets,maison,sport,automobile,autre',
            'description_marchandise' => 'required|string|max:2000',
            'photo_marchandise' => 'required',
            'photo_marchandise.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'quantite_souhaitee' => 'required|integer|min:1',
            'unite_mesure' => 'required|in:pieces,paires,lots,cartons,kg,metres',
            'budget_approximatif' => 'nullable|numeric|min:10000',
            'mode_expedition' => 'nullable|in:bateau,avion',
            'exigences_particulieres' => 'nullable|string|max:1000',
            'lieu_livraison' => 'required|in:bureau,domicile,point_relais',
            'adresse_livraison' => 'nullable|string|max:500',
            'ville_livraison' => 'required|string|max:100',
            'telephone_livraison' => 'required|string|max:20',
            'urgence' => 'required|in:normale,rapide,tres_rapide',
            'usage_prevu' => 'nullable|in:personnel,revente,cadeau,professionnel',
            'commentaires' => 'nullable|string|max:1000',
            'accepte_contact' => 'required|accepted',
            'accepte_conditions' => 'required|accepted',
        ], [
            'photo_marchandise.required' => 'Au moins une photo de la marchandise est obligatoire',
            'photo_marchandise.*.image' => 'Chaque fichier doit être une image',
            'photo_marchandise.*.mimes' => 'Les formats acceptés sont : JPEG, JPG, PNG, WEBP',
            'photo_marchandise.*.max' => 'Chaque image ne doit pas dépasser 5 MB',
        ]);

        // Vérification adresse si livraison à domicile
        if ($request->lieu_livraison === 'domicile' && !$request->adresse_livraison) {
            return back()->withErrors(['adresse_livraison' => 'L\'adresse est obligatoire pour une livraison à domicile'])->withInput();
        }

        // Vérifier si l'utilisateur a un compte
        $compte = Compte::where('user_id', auth()->id())->first();
        if (!$compte) {
            return back()->withErrors(['compte' => 'Vous devez d\'abord créer un compte client'])->withInput();
        }

        // Normaliser les fichiers en tableau
        $photos = $request->file('photo_marchandise');
        if (!is_array($photos)) {
            $photos = [$photos]; // convertir en tableau si une seule image
        }

        // Upload des photos
        $photoPaths = [];
        foreach ($photos as $photo) {
            $filename = Str::random(20) . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('import_export/photos', $filename, 'public');
            $photoPaths[] = $path;
        }

        // Création de la demande
        $importExport = ImportExport::create([
            'user_id' => Auth::id(),
            'nom_marchandise' => $request->nom_marchandise,
            'categorie' => $request->categorie,
            'description_marchandise' => $request->description_marchandise,
            'photos_marchandise' => $photoPaths,
            'quantite_souhaitee' => $request->quantite_souhaitee,
            'unite_mesure' => $request->unite_mesure,
            'budget_approximatif' => $request->budget_approximatif,
            'mode_expedition' => $request->mode_expedition,
            'exigences_particulieres' => $request->exigences_particulieres,
            'lieu_livraison' => $request->lieu_livraison,
            'adresse_livraison' => $request->adresse_livraison,
            'ville_livraison' => $request->ville_livraison,
            'telephone_livraison' => $request->telephone_livraison,
            'urgence' => $request->urgence,
            'usage_prevu' => $request->usage_prevu,
            'commentaires' => $request->commentaires,
            'accepte_contact' => true,
            'accepte_conditions' => true,
            'status' => 'en_attente',
            'historique_status' => [
                [
                    'status' => 'en_attente',
                    'date' => now(),
                    'note' => 'Demande d\'import/export créée'
                ]
            ]
        ]);

        return redirect()->route('success', $importExport->id)
            ->with('success', 'Votre demande d\'import/export a été soumise avec succès !');
    }

    /**
     * Afficher la page de succès
     */
    public function success(ImportExport $importExport)
    {
        // Vérifier que c'est bien la demande de l'utilisateur connecté
        if ($importExport->user_id !== auth()->id()) {
            abort(403);
        }

        return view('import.succes', compact('importExport'));
    }

    /**
     * Afficher le statut des demandes
     */
    public function status()
    {
        $demandes = ImportExport::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('import.status', compact('demandes'));
    }
    // vue dasboard gestionnaire import export
    public function dashboard(Request $request)
    {
         // Vérification des permissions
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $query = ImportExport::with('compte');

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_marchandise', 'like', "%{$search}%")
                  ->orWhere('description_marchandise', 'like', "%{$search}%")
                  ->orWhereHas('compte', function($subQ) use ($search) {
                      $subQ->where('nom', 'like', "%{$search}%")
                           ->orWhere('prenom', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $demandes = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calcul des statistiques
        $totalDemandes = ImportExport::count();
        $demandesEnAttente = ImportExport::where('status', 'en_attente')->count();
        $demandesEnTransit = ImportExport::whereIn('status', ['expedition', 'en_transit'])->count();
        $demandesLivrees = ImportExport::where('status', 'livre')->count();
        $montantTotalCommandes = ImportExport::sum('montant_paye_marchandise');

        return view('import.dashboard', compact(
            'demandes',
            'totalDemandes',
            'demandesEnAttente',
            'demandesEnTransit',
            'demandesLivrees',
            'montantTotalCommandes'
        ));
    }

    /**
     * Page de traitement d'une demande
     */
    public function traiter(ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        if ($demande->status !== 'en_attente') {
            return redirect()->route('import.dashboard')
                ->with('error', 'Cette demande ne peut plus être traitée');
        }

        return view('import.traiter', compact('demande'));
    }

     /**
     * Traitement POST d'une demande
     */
    public function traiterPost(Request $request, ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'decision' => 'required|in:recherche_en_cours,annule',
            'observations' => 'nullable|string|max:1000'
        ]);

        $demande->update([
            'status' => $request->decision,
            'observations' => $request->observations,
            'date_traitement' => now(),
            'traite_par' => auth()->id(),
            'historique_status' => array_merge($demande->historique_status ?? [], [
                [
                    'status' => $request->decision,
                    'date' => now(),
                    'note' => $request->observations,
                    'traite_par' => auth()->user()->name
                ]
            ])
        ]);

        $message = $request->decision === 'recherche_en_cours' ? 
            'Recherche lancée chez nos fournisseurs' : 
            'Demande annulée';

        return redirect()->route('dashboard.import')
            ->with('success', $message);
    }

    /**
     * Page de gestion des devis
     */
    public function devis(ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        return view('import.devis', compact('demande'));
    }

    /**
     * Enregistrer un devis
     */
    public function devisPost(Request $request, ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'prix_unitaire_propose' => 'required|numeric|min:0',
            'quantite_finale' => 'required|integer|min:1',
            'poids_estime_kg' => 'required|numeric|min:0.1',
            'mode_expedition_final' => 'required|in:bateau,avion',
            'details_devis' => 'nullable|string|max:2000'
        ]);

        $prixTotal = $request->prix_unitaire_propose * $request->quantite_finale;
        $fraisDouane = $request->poids_estime_kg * 10000; // 10,000 FCFA/kg
        $commission = $request->poids_estime_kg * 1000; // 1,000 FCFA/kg

        $demande->update([
            'prix_unitaire_propose' => $request->prix_unitaire_propose,
            'prix_total_marchandise' => $prixTotal,
            'quantite_finale' => $request->quantite_finale,
            'poids_estime_kg' => $request->poids_estime_kg,
            'frais_douane_estimes' => $fraisDouane,
            'commission_axe_capital' => $commission,
            'mode_expedition_final' => $request->mode_expedition_final,
            'details_devis' => $request->details_devis,
            'date_devis' => now(),
            'status' => 'devis_envoye',
            'historique_status' => array_merge($demande->historique_status ?? [], [
                [
                    'status' => 'devis_envoye',
                    'date' => now(),
                    'note' => 'Devis envoyé au client',
                    'traite_par' => auth()->user()->name
                ]
            ])
        ]);

        return redirect()->route('dashboard.import')
            ->with('success', 'Devis envoyé au client');
    }

    /**
     * Page de gestion des achats
     */
    public function achat(ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        return view('import.achat', compact('demande'));
    }

    /**
     * Enregistrer un achat en Chine
     */
    public function achatPost(Request $request, ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'numero_commande_chine' => 'required|string|max:100',
            'date_achat_chine' => 'required|date',
            'poids_final_kg' => 'required|numeric|min:0.1',
            'date_expedition' => 'nullable|date|after:date_achat_chine',
            'numero_suivi' => 'nullable|string|max:100',
            'informations_suivi' => 'nullable|string|max:1000'
        ]);

        // Recalculer les frais basés sur le poids final
        $fraisDouane = $request->poids_final_kg * 10000;
        $commission = $request->poids_final_kg * 1000;

        $status = $request->date_expedition ? 'expedition' : 'achat_en_cours';

        $demande->update([
            'numero_commande_chine' => $request->numero_commande_chine,
            'date_achat_chine' => $request->date_achat_chine,
            'poids_final_kg' => $request->poids_final_kg,
            'frais_douane_reels' => $fraisDouane,
            'commission_finale' => $commission,
            'date_expedition' => $request->date_expedition,
            'numero_suivi' => $request->numero_suivi,
            'informations_suivi' => $request->informations_suivi,
            'status' => $status,
            'historique_status' => array_merge($demande->historique_status ?? [], [
                [
                    'status' => $status,
                    'date' => now(),
                    'note' => 'Achat effectué en Chine',
                    'traite_par' => auth()->user()->name
                ]
            ])
        ]);

        return redirect()->route('dashboard.import')
            ->with('success', 'Informations d\'achat enregistrées');
    }

    /**
     * Page de gestion de la douane
     */
    public function douane(ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        return view('import.douane', compact('demande'));
    }

    /**
     * Gérer le dédouanement
     */
    public function douanePost(Request $request, ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'frais_douane_payes' => 'boolean',
            'commission_payee' => 'boolean',
            'frais_livraison' => 'nullable|numeric|min:0',
            'date_livraison' => 'nullable|date',
            'notes_livraison' => 'nullable|string|max:500'
        ]);

        $status = 'dedouanement';
        if ($request->frais_douane_payes && $request->commission_payee) {
            if ($request->date_livraison) {
                $status = 'livre';
            } else {
                $status = 'pret_livraison';
            }
        }

        $demande->update([
            'frais_douane_payes' => $request->frais_douane_payes ?? false,
            'commission_payee' => $request->commission_payee ?? false,
            'frais_livraison' => $request->frais_livraison,
            'date_paiement_frais' => ($request->frais_douane_payes && $request->commission_payee) ? now() : null,
            'date_livraison' => $request->date_livraison,
            'notes_livraison' => $request->notes_livraison,
            'status' => $status,
            'historique_status' => array_merge($demande->historique_status ?? [], [
                [
                    'status' => $status,
                    'date' => now(),
                    'note' => 'Gestion douane et livraison',
                    'traite_par' => auth()->user()->name
                ]
            ])
        ]);

        return redirect()->route('dashboard.import')
            ->with('success', 'Informations de dédouanement mises à jour');
    }

    /**
     * Page de suivi d'expédition
     */
    public function suivi(ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        return view('import.suivi', compact('demande'));
    }

    /**
     * Mettre à jour le suivi
     */
    public function suiviPost(Request $request, ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'status' => 'required|in:expedition,en_transit,arrivee',
            'date_arrivee_prevue' => 'nullable|date',
            'date_arrivee_effective' => 'nullable|date',
            'informations_suivi' => 'nullable|string|max:1000'
        ]);

        $demande->update([
            'status' => $request->status,
            'date_arrivee_prevue' => $request->date_arrivee_prevue,
            'date_arrivee_effective' => $request->date_arrivee_effective,
            'informations_suivi' => $request->informations_suivi,
            'historique_status' => array_merge($demande->historique_status ?? [], [
                [
                    'status' => $request->status,
                    'date' => now(),
                    'note' => $request->informations_suivi,
                    'traite_par' => auth()->user()->name
                ]
            ])
        ]);

        return redirect()->route('dashboard.import')
            ->with('success', 'Suivi mis à jour');
    }
    /**
     * Détails d'une demande
     */
    public function details(ImportExport $demande)
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $demande->load('compte');
        
        return view('import.details', compact('demande'));
    }

    /**
     * Afficher une photo de marchandise
     */
    public function photo(ImportExport $demande, $index)
    {
        if (auth()->user()->role !== 'gestionnaire_import_export') {
            abort(403, 'Accès non autorisé');
        }

        if (!$demande->photos_marchandise || !isset($demande->photos_marchandise[$index])) {
            abort(404, 'Photo non trouvée');
        }

        $photoPath = $demande->photos_marchandise[$index];
        
        if (!Storage::disk('public')->exists($photoPath)) {
            abort(404, 'Fichier photo non trouvé');
        }

        $fullPath = Storage::disk('public')->path($photoPath);
        $mimeType = Storage::disk('public')->mimeType($photoPath);

        return Response::file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline'
        ]);
    }

    /**
 * Afficher la page de confirmation du devis
 */
public function confirmDevis(ImportExport $importExport)
{
    // Vérifier que la demande appartient à l'utilisateur connecté
    if ($importExport->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé');
    }

    // Vérifier que le devis peut être confirmé
    if ($importExport->status !== 'devis_envoye') {
        return redirect()->route('status')
            ->with('error', 'Ce devis ne peut plus être confirmé');
    }

    return view('import.confirm', compact('importExport'));
}

/**
 * Confirmer le devis (POST)
 */
public function confirmDevisPost(ImportExport $importExport)
{
    // Vérifier que la demande appartient à l'utilisateur connecté
    if ($importExport->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé');
    }

    // Vérifier que le devis peut être confirmé
    if ($importExport->status !== 'devis_envoye') {
        return redirect()->route('status')
            ->with('error', 'Ce devis ne peut plus être confirmé');
    }

    // Mettre à jour le statut
    $importExport->update([
        'status' => 'commande_confirmee',
        'historique_status' => array_merge($importExport->historique_status ?? [], [
            [
                'status' => 'commande_confirmee',
                'date' => now(),
                'note' => 'Devis accepté par le client',
                'action_par' => auth()->user()->name ?? 'Client'
            ]
        ])
    ]);

    return redirect()->route('status')
        ->with('success', 'Devis confirmé ! Veuillez procéder au paiement pour que nous puissions commander votre marchandise.');
}


/**
 * Rejeter le devis
 */
public function rejectDevis(ImportExport $importExport)
{
    // Vérifier que c'est bien la demande de l'utilisateur connecté
     if ($importExport->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé');
    }

    // Vérifier que le devis peut être rejeté
    if ($importExport->status !== 'devis_envoye') {
        return redirect()->route('status')
            ->with('error', 'Ce devis ne peut plus être modifié');
    }

    return view('import.reject', compact('importExport'));
}

/**
 * Confirmer le rejet du devis (POST)
 */
public function rejectDevisPost(Request $request, ImportExport $importExport)
{
    // Vérifier que c'est bien la demande de l'utilisateur connecté
     if ($importExport->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé');
    }

    $request->validate([
        'motif_rejet' => 'nullable|string|max:500'
    ]);

    // Remettre en recherche ou annuler selon le choix
    $nouveauStatut = $request->input('action', 'recherche_en_cours');
    
    $importExport->update([
        'status' => $nouveauStatut,
        'observations' => $request->motif_rejet,
        'historique_status' => array_merge($importExport->historique_status ?? [], [
            [
                'status' => $nouveauStatut,
                'date' => now(),
                'note' => $request->motif_rejet ?: 'Devis rejeté par le client',
                'action_par' => auth()->user()->name ?? 'Client'
            ]
        ])
    ]);

    $message = $nouveauStatut === 'recherche_en_cours' ? 
        'Devis rejeté. Nous recherchons une alternative qui correspond mieux à vos attentes.' : 
        'Demande annulée suite au rejet du devis.';

    return redirect()->route('status')
        ->with('success', $message);
}
   
    public function export()
    {
        if (auth()->user()->role !== 'gest-import') {
            abort(403, 'Accès non autorisé');
        }

        $demandes = ImportExport::with('compte')->get();
        
        $filename = 'import_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use($demandes) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Référence',
                'Client',
                'Téléphone',
                'Marchandise',
                'Catégorie',
                'Quantité',
                'Unité',
                'Prix Total',
                'Poids (kg)',
                'Mode Expédition',
                'Statut',
                'Date Création',
                'Date Livraison'
            ], ';');

            // Données
            foreach ($demandes as $demande) {
                fputcsv($file, [
                    $demande->id,
                    $demande->numero_reference,
                    ($demande->compte->nom ?? '') . ' ' . ($demande->compte->prenom ?? ''),
                    $demande->telephone_livraison ?? $demande->compte->telephone ?? '',
                    $demande->nom_marchandise,
                    $demande->categorie,
                    $demande->quantite_finale ?? $demande->quantite_souhaitee,
                    $demande->unite_mesure,
                    $demande->prix_total_marchandise ?? '',
                    $demande->poids_final_kg ?? $demande->poids_estime_kg ?? '',
                    $demande->mode_expedition_final ?? $demande->mode_expedition ?? '',
                    $demande->status,
                    $demande->created_at->format('d/m/Y H:i'),
                    $demande->date_livraison ? Carbon::parse($demande->date_livraison)->format('d/m/Y H:i') : ''
                ], ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
