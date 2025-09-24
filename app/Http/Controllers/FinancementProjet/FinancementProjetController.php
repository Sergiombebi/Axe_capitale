<?php

namespace App\Http\Controllers\FinancementProjet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compte;
use Illuminate\Support\Str;
use App\Models\FinancementProjet;
use App\Models\User;


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
            'business_plan' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
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
}
