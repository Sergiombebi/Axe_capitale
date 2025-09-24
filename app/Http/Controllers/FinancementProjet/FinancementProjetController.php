<?php

namespace App\Http\Controllers\FinancementProjet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compte;
use Illuminate\Support\Str;
use App\Models\FinancementProjet;
use App\Models\User;
use App\Models\ImportExport;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class FinancementProjetController  extends Controller
{
    public function financement()
    {
        return view('financementProjet.financement');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom_projet' => 'required|string|max:255',
            'secteur_activite' => 'required|in:agriculture,commerce,artisanat,services,technologie,tourisme,education,sante,transport,autre',
            'description_projet' => 'required|string|max:2000',
            'montant_total_projet' => 'required|numeric|min:100000',
            'montant_financement_demande' => 'required|numeric|min:50000',
            'apport_personnel' => 'required|numeric|min:10000',
            'duree_remboursement' => 'required|integer|in:12,18,24,36,48,60',
            'nature_apport' => 'required|string|max:1000',
           'business_plan' => 'required|file|max:5120', // Accepte tous formats // 5MB
            'photocopie_cni' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB
            'plan_localisation' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'attestation_niu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'experience_domaine' => 'nullable|in:aucune,moins_1_an,1_3_ans,3_5_ans,plus_5_ans',
            'employes_prevus' => 'nullable|integer|min:0|max:100',
            'objectifs_court_terme' => 'nullable|string|max:1000',
            'objectifs_long_terme' => 'nullable|string|max:1000',
            'accepte_frais_etude' => 'required|accepted',
            'accepte_conditions' => 'required|accepted',
        ], [
            'montant_total_projet.min' => 'Le montant total du projet doit être d\'au moins 100 000 FCFA',
            'montant_financement_demande.min' => 'Le montant du financement demandé doit être d\'au moins 50 000 FCFA',
            'apport_personnel.min' => 'L\'apport personnel doit être d\'au moins 10 000 FCFA',
            'business_plan.required' => 'Le business plan est obligatoire',
            'business_plan.mimes' => 'Le business plan doit être au format PDF, DOC ou DOCX',
            'business_plan.max' => 'Le business plan ne doit pas dépasser 5 MB',
            'accepte_frais_etude.accepted' => 'Vous devez accepter de payer les frais d\'étude',
            'accepte_conditions.accepted' => 'Vous devez accepter les conditions générales',
        ]);

        // Vérifications métier
        if ($request->montant_financement_demande > $request->montant_total_projet) {
            return back()->withErrors(['montant_financement_demande' => 'Le montant du financement ne peut pas dépasser le montant total du projet'])->withInput();
        }

        if (($request->apport_personnel + $request->montant_financement_demande) < $request->montant_total_projet) {
            return back()->withErrors(['montant_total_projet' => 'La somme de l\'apport personnel et du financement demandé doit couvrir le montant total du projet'])->withInput();
        }

        // Récupérer le compte de l'utilisateur connecté
        $compte = Compte::where('user_id', auth()->id())->first();
        if (!$compte) {
            return back()->withErrors(['compte' => 'Vous devez d\'abord créer un compte client'])->withInput();
        }

        // Upload des fichiers
        $businessPlan = $this->uploadFile($request->file('business_plan'), 'financement/business_plans');
        $photocopieCni = $this->uploadFile($request->file('photocopie_cni'), 'financement/cni');
        $planLocalisation = $this->uploadFile($request->file('plan_localisation'), 'financement/plans');
        $attestationNiu = $this->uploadFile($request->file('attestation_niu'), 'financement/niu');

        // Créer la demande de financement
        $financementProjet =  FinancementProjet::create([
            'compte_id' => $compte->id,
            'nom_projet' => $request->nom_projet,
            'secteur_activite' => $request->secteur_activite,
            'description_projet' => $request->description_projet,
            'montant_total_projet' => $request->montant_total_projet,
            'montant_financement_demande' => $request->montant_financement_demande,
            'apport_personnel' => $request->apport_personnel,
            'duree_remboursement' => $request->duree_remboursement,
            'nature_apport' => $request->nature_apport,
            'business_plan' => $businessPlan,
            'photocopie_cni' => $photocopieCni,
            'plan_localisation' => $planLocalisation,
            'attestation_niu' => $attestationNiu,
            'experience_domaine' => $request->experience_domaine,
            'employes_prevus' => $request->employes_prevus,
            'objectifs_court_terme' => $request->objectifs_court_terme,
            'objectifs_long_terme' => $request->objectifs_long_terme,
            'accepte_frais_etude' => true,
            'accepte_conditions' => true,
            'status' => 'frais_en_attente',
            'historique_status' => [
                [
                    'status' => 'frais_en_attente',
                    'date' => now(),
                    'note' => 'Demande de financement créée'
                ]
            ]
        ]);

        return redirect()->route('projet.success', $financementProjet->id)
            ->with('success', 'Votre demande de financement a été soumise avec succès !');
    }
    private function uploadFile($file, $directory)
    {
        $filename = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }
    public function success(FinancementProjet $financementProjet)
    {
        // Vérifier que c'est bien le projet de l'utilisateur connecté
        if ($financementProjet->compte->user_id !== auth()->id()) {
            abort(403);
        }

        return view('financementProjet.success', compact('financementProjet'));
    }
    public function status()
    {
        $compte = Compte::where('user_id', auth()->id())->first();
        if (!$compte) {
            return redirect()->route('home')->with('error', 'Aucun compte trouvé');
        }

        $projets = FinancementProjet::where('compte_id', $compte->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('financementProjet.status', compact('projets'));
    }
    /**
     * Dashboard principal du gestionnaire de financement
     */
    public function dashboard(Request $request)
    {
        // Vérification des permissions
        if (Auth::user()->role !== 'gest-financement') {
            abort(403, 'Accès non autorisé');
        }

        // Construction de la requête avec filtres
        $query = FinancementProjet::with('compte.user');

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_projet', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('compte', function($compte) use ($search) {
                      $compte->where('nom', 'like', "%{$search}%")
                             ->orWhere('prenom', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('secteur')) {
            $query->where('secteur_activite', $request->secteur);
        }

        // Récupération des projets avec pagination
        $projets = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistiques générales
        $totalProjets = FinancementProjet::count();
        $projetsEnAttenteFrais = FinancementProjet::where('status', 'frais_en_attente')->count();
        $projetsEnEtude = FinancementProjet::where('status', 'en_etude')->count();
        $projetsApprouves = FinancementProjet::where('status', 'approuve')->count();
        $montantTotalDemande = FinancementProjet::sum('montant_financement_demande');
        $montantTotalFinance = FinancementProjet::whereNotNull('montant_finance')->sum('montant_finance');

        // Actions récentes
        $actionsRecentes = $this->getActionsRecentes();

        // Alertes
        $alertes = $this->getAlertes();

        // Statistiques par secteur
        $statistiquesSecteurs = FinancementProjet::selectRaw('secteur_activite, count(*) as count')
            ->groupBy('secteur_activite')
            ->pluck('count', 'secteur_activite');

        // Projets nécessitant une attention
        $projetsAttention = $this->getProjetsNecessitantAttention();

        // Performance mensuelle
        $performanceMensuelle = $this->getPerformanceMensuelle();

        return view('financementProjet.dashboard', compact(
            'projets',
            'totalProjets',
            'projetsEnAttenteFrais',
            'projetsEnEtude',
            'projetsApprouves',
            'montantTotalDemande',
            'montantTotalFinance',
            'actionsRecentes',
            'alertes',
            'statistiquesSecteurs',
            'projetsAttention',
            'performanceMensuelle'
        ));
    }
    private function getActionsRecentes()
    {
        // Simuler des actions récentes - en réalité, vous devriez avoir une table d'audit
        return collect([
            (object)['action' => 'Projet approuvé', 'projet_nom' => 'Boutique en ligne', 'client_nom' => 'Jean Dupont', 'created_at' => now()->subHours(2)],
            (object)['action' => 'Frais confirmés', 'projet_nom' => 'Ferme avicole', 'client_nom' => 'Marie Martin', 'created_at' => now()->subHours(5)],
        ]);
    }
    private function getPerformanceMensuelle()
    {
        $debutMois = now()->startOfMonth();
        
        return (object)[
            'nouveaux_projets' => FinancementProjet::where('created_at', '>=', $debutMois)->count(),
            'projets_finances' => FinancementProjet::where('status', 'finance')
                ->where('updated_at', '>=', $debutMois)->count(),
            'montant_finance' => FinancementProjet::where('status', 'finance')
                ->where('updated_at', '>=', $debutMois)
                ->sum('montant_finance'),
            'taux_approbation' => $this->calculerTauxApprobation($debutMois)
        ];
    }
    private function getProjetsNecessitantAttention()
    {
        $projets = collect();
        
        // Projets avec frais non payés depuis plus de 5 jours
        $projetsRetard = FinancementProjet::with('compte')
            ->where('status', 'frais_en_attente')
            ->where('created_at', '<', now()->subDays(5))
            ->get();
            
        foreach ($projetsRetard as $projet) {
            $projet->raison_attention = 'Frais en attente depuis ' . $projet->created_at->diffInDays() . ' jours';
            $projets->push($projet);
        }
        
        return $projets;
    }
    private function getAlertes()
    {
        $alertes = collect();
        
        // Projets en attente de frais depuis plus de 7 jours
        $projetsEnRetard = FinancementProjet::where('status', 'frais_en_attente')
            ->where('created_at', '<', now()->subDays(7))
            ->get();
            
        foreach ($projetsEnRetard as $projet) {
            $alertes->push((object)[
                'type' => 'urgent',
                'titre' => 'Projet en attente depuis ' . $projet->created_at->diffInDays() . ' jours',
                'message' => 'Le projet "' . $projet->nom_projet . '" attend le paiement des frais',
                'lien' => route('details', $projet->id),
                'created_at' => $projet->created_at
            ]);
        }
        
        return $alertes;
    }
    private function calculerTauxApprobation($depuis)
    {
        $totalEvalues = FinancementProjet::whereIn('status', ['approuve', 'rejete'])
            ->where('date_traitement', '>=', $depuis)->count();
            
        if ($totalEvalues == 0) return 0;
        
        $approuves = FinancementProjet::where('status', 'approuve')
            ->where('date_traitement', '>=', $depuis)->count();
            
        return ($approuves / $totalEvalues) * 100;
    }

    /**
     * Confirmer le paiement des frais d'étude
     */
    public function confirmerPaiement(FinancementProjet $projet)
    {
        return view('financementProjet.confirmer_paiement', compact('projet'));
    }
    public function validerPaiement(Request $request, FinancementProjet $projet)
    {
        $request->validate([
            'confirmation' => 'required|accepted',
            'date_paiement' => 'required|date',
            'observations' => 'nullable|string|max:1000'
        ]);

        $projet->update([
            'frais_etude_paye' => true,
            'date_paiement_frais' => $request->date_paiement,
            'observations' => $request->observations,
            'historique_status' => array_merge($projet->historique_status ?? [], [
                [
                    'status' => 'frais_paye',
                    'date' => now(),
                    'note' => 'Frais d\'étude confirmés payés',
                    'traite_par' => auth()->id()
                ]
            ])
        ]);

        // Notification au client
        // $this->envoyerNotification($projet, 'Frais confirmés', 
        //     'Vos frais d\'étude ont été confirmés. L\'analyse de votre business plan va commencer.');

        return redirect()->route('projet.dashboard')
            ->with('success', 'Paiement des frais confirmé avec succès');
    }
    /**
     * Étudier le business plan
     */
    public function etudier(FinancementProjet $projet)
    {
        if (!$projet->frais_etude_paye) {
            return back()->withErrors(['error' => 'Les frais d\'étude doivent être payés avant l\'analyse']);
        }

        return view('financementProjet.etudier', compact('projet'));
    }
    public function marquerEnEtude(Request $request, FinancementProjet $projet)
    {
        $request->validate([
            'observations_etude' => 'nullable|string|max:2000',
            'delai_etude_jours' => 'required|integer|min:1|max:30'
        ]);

        $projet->update([
            'status' => 'en_etude',
            'observations' => $request->observations_etude,
            'traite_par' => auth()->id(),
            'date_traitement' => now(),
            'historique_status' => array_merge($projet->historique_status ?? [], [
                [
                    'status' => 'en_etude',
                    'date' => now(),
                    'note' => 'Business plan en cours d\'analyse - Délai: ' . $request->delai_etude_jours . ' jours',
                    'traite_par' => auth()->id()
                ]
            ])
        ]);

        // Notification au client
        // $this->envoyerNotification($projet, 'Analyse en cours', 
        //     "Votre business plan est en cours d'analyse. Résultat attendu dans {$request->delai_etude_jours} jours.");

        return redirect()->route('projet.dashboard')
            ->with('success', 'Projet marqué en étude');
    }
    /**
     * Évaluer le projet
     */
    public function evaluer(FinancementProjet $projet)
    {
        if ($projet->status !== 'en_etude') {
            return back()->withErrors(['error' => 'Ce projet n\'est pas en cours d\'étude']);
        }

        return view('financementProjet.evaluer', compact('projet'));
    }

    public function prendreDecision(Request $request, FinancementProjet $projet)
    {
        $request->validate([
            'decision' => 'required|in:approuve,rejete',
            'motif_rejet' => 'required_if:decision,rejete|nullable|string|max:2000',
            'observations_evaluation' => 'nullable|string|max:2000',
            'montant_finance_propose' => 'required_if:decision,approuve|nullable|numeric|min:0',
            'duree_remboursement_accordee' => 'required_if:decision,approuve|nullable|integer|min:6|max:60',
            'ratio_remboursement' => 'required_if:decision,approuve|nullable|numeric|min:0|max:100'
        ]);

        $updateData = [
            'status' => $request->decision,
            'observations' => $request->observations_evaluation,
            'traite_par' => auth()->id(),
            'date_traitement' => now()
        ];

        if ($request->decision === 'rejete') {
            $updateData['motif_rejet'] = $request->motif_rejet;
        } else {
            $updateData['date_approbation'] = now();
            $updateData['montant_finance'] = $request->montant_finance_propose;
            $updateData['duree_remboursement_accordee'] = $request->duree_remboursement_accordee;
            $updateData['ratio_remboursement'] = $request->ratio_remboursement;
            $updateData['solde_restant'] = $request->montant_finance_propose;
        }

        // Mise à jour de l'historique
        $updateData['historique_status'] = array_merge($projet->historique_status ?? [], [
            [
                'status' => $request->decision,
                'date' => now(),
                'note' => $request->decision === 'approuve' 
                    ? "Projet approuvé - Financement: " . number_format($request->montant_finance_propose, 0, ',', ' ') . " FCFA"
                    : "Projet rejeté - Motif: " . $request->motif_rejet,
                'traite_par' => auth()->id()
            ]
        ]);

        $projet->update($updateData);

        // // Notification au client
        // if ($request->decision === 'approuve') {
        //     $this->envoyerNotification($projet, 'Projet approuvé !', 
        //         "Félicitations ! Votre projet a été approuvé pour un financement de " . 
        //         number_format($request->montant_finance_propose, 0, ',', ' ') . " FCFA");
        // } else {
        //     $this->envoyerNotification($projet, 'Projet non retenu', 
        //         "Nous regrettons de vous informer que votre projet n'a pas été retenu. Motif: " . $request->motif_rejet);
        // }

        return redirect()->route('projet.dashboard')
            ->with('success', 'Décision enregistrée avec succès');
    }
    /**
     * Financer le projet approuvé
     */
    public function financer(FinancementProjet $projet)
    {
        if ($projet->status !== 'approuve') {
            return back()->withErrors(['error' => 'Ce projet n\'est pas approuvé']);
        }

        return view('financementProjet.financer', compact('projet'));
    }
    public function accorderFinancement(Request $request, FinancementProjet $projet)
    {
        $request->validate([
            'confirmation_financement' => 'required|accepted',
            'date_debut_remboursement' => 'required|date|after:today',
            'conditions_remboursement' => 'required|string|max:2000',
            'observations_financement' => 'nullable|string|max:1000'
        ]);

        $dateFinRemboursement = Carbon::parse($request->date_debut_remboursement)
            ->addMonths($projet->duree_remboursement_accordee);

        $projet->update([
            'status' => 'finance',
            'date_debut_remboursement' => $request->date_debut_remboursement,
            'date_fin_remboursement' => $dateFinRemboursement,
            'conditions_remboursement' => $request->conditions_remboursement,
            'observations' => $request->observations_financement,
            'historique_status' => array_merge($projet->historique_status ?? [], [
                [
                    'status' => 'finance',
                    'date' => now(),
                    'note' => 'Financement accordé - Début remboursement: ' . 
                             Carbon::parse($request->date_debut_remboursement)->format('d/m/Y'),
                    'traite_par' => auth()->id()
                ]
            ])
        ]);

        // Notification au client
        // $this->envoyerNotification($projet, 'Financement accordé !', 
        //     "Votre financement de " . number_format($projet->montant_finance, 0, ',', ' ') . 
        //     " FCFA a été accordé. Le remboursement commencera le " . 
        //     Carbon::parse($request->date_debut_remboursement)->format('d/m/Y'));

        return redirect()->route('projet.dashboard')
            ->with('success', 'Financement accordé avec succès');
    }
    /**
     * Suivi du projet financé
     */
    public function suivi(FinancementProjet $projet)
    {
        if (!in_array($projet->status, ['finance', 'en_cours'])) {
            return back()->withErrors(['error' => 'Ce projet n\'est pas financé']);
        }

        return view('financementProjet.suivi', compact('projet'));
    }
    
    public function mettreAJourSuivi(Request $request, FinancementProjet $projet)
    {
        $request->validate([
            'nouveau_statut' => 'required|in:finance,en_cours,termine,suspendu',
            'montant_rembourse' => 'nullable|numeric|min:0',
            'observations_suivi' => 'nullable|string|max:2000'
        ]);

        $updateData = [
            'status' => $request->nouveau_statut,
            'observations' => $request->observations_suivi
        ];

        if ($request->filled('montant_rembourse')) {
            $updateData['montant_rembourse'] = $request->montant_rembourse;
            $updateData['solde_restant'] = $projet->montant_finance - $request->montant_rembourse;
        }

        $updateData['historique_status'] = array_merge($projet->historique_status ?? [], [
            [
                'status' => $request->nouveau_statut,
                'date' => now(),
                'note' => 'Mise à jour du suivi - ' . $request->observations_suivi,
                'traite_par' => auth()->id()
            ]
        ]);

        $projet->update($updateData);

        return redirect()->route('projet.dashboard')
            ->with('success', 'Suivi mis à jour avec succès');
    }
    public function details(FinancementProjet $projet)
    {
        $projet->load('compte.user');
        return view('financementProjet.details', compact('projet'));
    }
     public function getProjetsAttention()
    {
        return response()->json($this->getProjetsNecessitantAttention());
    }

    public function getPerformance()
    {
        return response()->json($this->getPerformanceMensuelle());
    }
    public function export(Request $request)
    {
        $projets = FinancementProjet::with('compte')->get();
        
        // Vous pouvez utiliser Laravel Excel ou une autre solution d'export
        // Pour l'exemple, retournons un CSV simple
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="projets_financement_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($projets) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nom Projet', 'Client', 'Secteur', 'Montant Demandé', 'Montant Financé', 'Statut', 'Date Création']);
            
            foreach ($projets as $projet) {
                fputcsv($file, [
                    $projet->id,
                    $projet->nom_projet,
                    $projet->compte->nom . ' ' . $projet->compte->prenom,
                    $projet->secteur_activite,
                    $projet->montant_financement_demande,
                    $projet->montant_finance ?? 0,
                    $projet->status,
                    $projet->created_at->format('d/m/Y')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
