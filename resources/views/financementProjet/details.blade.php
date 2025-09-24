@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Détails Complets du Projet</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">{{ $projet->nom_projet }} - FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="#" target="_blank"
                        style="background: #9f7aea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Rapport PDF
                    </a>
                    <a href="{{ route('projet.dashboard') }}" 
                        style="background: #a0aec0; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Retour
                    </a>
                </div>
            </div>

            {{-- Statut actuel avec badge --}}
            @php
            $statusStyles = [
                'frais_en_attente' => 'background: #fef3c7; color: #92400e;',
                'en_etude' => 'background: #dbeafe; color: #1d4ed8;',
                'approuve' => 'background: #dcfce7; color: #166534;',
                'rejete' => 'background: #fecaca; color: #991b1b;',
                'finance' => 'background: #dcfce7; color: #166534;',
                'en_cours' => 'background: #e0f2fe; color: #0c4a6e;',
                'termine' => 'background: #dcfce7; color: #166534;',
                'suspendu' => 'background: #fecaca; color: #991b1b;'
            ];
            $statusLabels = [
                'frais_en_attente' => 'Frais en Attente',
                'en_etude' => 'En Étude',
                'approuve' => 'Approuvé',
                'rejete' => 'Rejeté',
                'finance' => 'Financé',
                'en_cours' => 'En Cours',
                'termine' => 'Terminé',
                'suspendu' => 'Suspendu'
            ];
            @endphp

            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="padding: 10px 20px; border-radius: 20px; font-size: 1rem; font-weight: 600; {{ $statusStyles[$projet->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                    {{ $statusLabels[$projet->status] ?? 'Inconnu' }}
                </span>
                @if($projet->frais_etude_paye)
                <span style="background: #dcfce7; color: #166534; padding: 8px 15px; border-radius: 15px; font-size: 0.9rem; font-weight: 600;">
                    ✓ Frais payés
                </span>
                @endif
                <span style="background: #e2e8f0; color: #4a5568; padding: 8px 15px; border-radius: 15px; font-size: 0.9rem;">
                    Créé le {{ $projet->created_at->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            {{-- Partie gauche - Informations détaillées --}}
            <div>
                {{-- Informations du projet --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations du Projet</h3>
                    
                    <div style="display: grid; gap: 20px;">
                        <div>
                            <h4 style="color: #4a5568; margin: 0 0 10px 0; font-size: 1rem;">Description</h4>
                            <div style="background: #f7fafc; padding: 15px; border-radius: 8px; line-height: 1.6; color: #2d3748;">
                                {{ $projet->description_projet }}
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Secteur d'Activité</div>
                                <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($projet->secteur_activite) }}</div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Expérience du Porteur</div>
                                <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">
                                    {{ str_replace('_', ' ', $projet->experience_domaine ?? 'Non spécifié') }}
                                </div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Emplois Prévus</div>
                                <div style="color: #2d3748; font-weight: 600;">{{ $projet->employes_prevus ?? 'Non spécifié' }}</div>
                            </div>
                        </div>

                        @if($projet->objectifs_court_terme || $projet->objectifs_long_terme)
                        <div>
                            <h4 style="color: #4a5568; margin: 0 0 15px 0; font-size: 1rem;">Objectifs</h4>
                            <div style="display: grid; gap: 15px;">
                                @if($projet->objectifs_court_terme)
                                <div>
                                    <div style="color: #4299e1; font-weight: 600; margin-bottom: 8px;">Court Terme</div>
                                    <div style="background: #ebf8ff; padding: 12px; border-radius: 6px; color: #1e40af; border-left: 4px solid #4299e1;">
                                        {{ $projet->objectifs_court_terme }}
                                    </div>
                                </div>
                                @endif
                                
                                @if($projet->objectifs_long_terme)
                                <div>
                                    <div style="color: #9f7aea; font-weight: 600; margin-bottom: 8px;">Long Terme</div>
                                    <div style="background: #faf5ff; padding: 12px; border-radius: 6px; color: #7c3aed; border-left: 4px solid #9f7aea;">
                                        {{ $projet->objectifs_long_terme }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($projet->nature_apport)
                        <div>
                            <h4 style="color: #4a5568; margin: 0 0 10px 0; font-size: 1rem;">Nature de l'Apport Personnel</h4>
                            <div style="background: #f0fff4; padding: 15px; border-radius: 8px; color: #166534; border-left: 4px solid #10b981;">
                                {{ $projet->nature_apport }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Analyse financière --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Analyse Financière</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 20px;">
                        <div style="background: #f0fff4; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: #166534; margin-bottom: 5px;">
                                {{ number_format($projet->montant_total_projet, 0, ',', ' ') }}
                            </div>
                            <div style="color: #166534; font-size: 0.9rem;">Montant Total (FCFA)</div>
                        </div>

                        <div style="background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: #1e40af; margin-bottom: 5px;">
                                {{ number_format($projet->montant_financement_demande, 0, ',', ' ') }}
                            </div>
                            <div style="color: #1e40af; font-size: 0.9rem;">Financement Demandé</div>
                        </div>

                        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: #92400e; margin-bottom: 5px;">
                                {{ number_format($projet->apport_personnel, 0, ',', ' ') }}
                            </div>
                            <div style="color: #92400e; font-size: 0.9rem;">Apport Personnel</div>
                        </div>

                        <div style="background: #faf5ff; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: #7c3aed; margin-bottom: 5px;">
                                {{ round(($projet->montant_financement_demande / $projet->montant_total_projet) * 100, 1) }}%
                            </div>
                            <div style="color: #7c3aed; font-size: 0.9rem;">Ratio Financement</div>
                        </div>

                        <div style="background: #e0f2fe; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: #0c4a6e; margin-bottom: 5px;">
                                {{ $projet->duree_remboursement }}
                            </div>
                            <div style="color: #0c4a6e; font-size: 0.9rem;">Durée Souhaitée (mois)</div>
                        </div>

                        @if($projet->montant_finance)
                        <div style="background: #dcfce7; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.3rem; font-weight: 700; color: #166534; margin-bottom: 5px;">
                                {{ number_format($projet->montant_finance, 0, ',', ' ') }}
                            </div>
                            <div style="color: #166534; font-size: 0.9rem;">Montant Financé</div>
                        </div>
                        @endif
                    </div>

                    @if($projet->status === 'finance' || $projet->status === 'en_cours' || $projet->status === 'termine')
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px;">
                        <h4 style="color: #2d3748; margin: 0 0 15px 0;">Suivi des Remboursements</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Montant Remboursé</div>
                                <div style="color: #10b981; font-weight: 600;">{{ number_format($projet->montant_rembourse, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Solde Restant</div>
                                <div style="color: #e53e3e; font-weight: 600;">{{ number_format($projet->solde_restant, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Progression</div>
                                <div style="color: #4299e1; font-weight: 600;">
                                    {{ $projet->montant_finance > 0 ? round(($projet->montant_rembourse / $projet->montant_finance) * 100, 1) : 0 }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Documents --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Documents Fournis</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        @if($projet->business_plan)
                        <div style="background: #f7fafc; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">📊</div>
                            <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Business Plan</div>
                            <a href="{{ asset('storage/' . $projet->business_plan) }}" target="_blank"
                                style="background: #4299e1; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                Télécharger
                            </a>
                        </div>
                        @endif

                        @if($projet->photocopie_cni)
                        <div style="background: #f7fafc; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">🆔</div>
                            <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Photocopie CNI</div>
                            <a href="{{ asset('storage/' . $projet->photocopie_cni) }}" target="_blank"
                                style="background: #48bb78; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                Voir
                            </a>
                        </div>
                        @endif

                        @if($projet->plan_localisation)
                        <div style="background: #f7fafc; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">🗺️</div>
                            <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Plan de Localisation</div>
                            <a href="{{ asset('storage/' . $projet->plan_localisation) }}" target="_blank"
                                style="background: #ed8936; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                Voir
                            </a>
                        </div>
                        @endif

                        @if($projet->attestation_niu)
                        <div style="background: #f7fafc; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">📜</div>
                            <div style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Attestation NIU</div>
                            <a href="{{ asset('storage/' . $projet->attestation_niu) }}" target="_blank"
                                style="background: #9f7aea; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                Voir
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Observations et notes --}}
                @if($projet->observations || $projet->motif_rejet)
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Observations</h3>
                    
                    @if($projet->motif_rejet)
                    <div style="background: #fecaca; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 20px;">
                        <h4 style="color: #991b1b; margin: 0 0 8px 0;">Motif de Rejet</h4>
                        <div style="color: #7f1d1d; line-height: 1.6;">{{ $projet->motif_rejet }}</div>
                    </div>
                    @endif

                    @if($projet->observations)
                    <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4299e1;">
                        <h4 style="color: #1e40af; margin: 0 0 8px 0;">Notes du Gestionnaire</h4>
                        <div style="color: #1e3a8a; line-height: 1.6; white-space: pre-line;">{{ $projet->observations }}</div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            {{-- Partie droite - Client et actions --}}
            <div>
                {{-- Informations client --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations Client</h3>
                    
                    <div style="text-align: center; margin-bottom: 20px;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; color: white; font-size: 2rem; font-weight: 700;">
                            {{ substr($projet->compte->nom, 0, 1) }}{{ substr($projet->compte->prenom, 0, 1) }}
                        </div>
                        <div style="font-weight: 600; color: #2d3748; font-size: 1.2rem; margin-bottom: 8px;">{{ $projet->compte->nom }} {{ $projet->compte->prenom }}</div>
                        <div style="color: #718096; margin-bottom: 5px;">{{ $projet->compte->telephone }}</div>
                        @if($projet->compte->email)
                        <div style="color: #718096; font-size: 0.9rem;">{{ $projet->compte->email }}</div>
                        @endif
                    </div>

                    <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                        <div style="display: grid; gap: 10px; font-size: 0.9rem;">
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Compte créé</span>
                                <span style="color: #2d3748; font-weight: 600;">{{ $projet->compte->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Ville</span>
                                <span style="color: #2d3748; font-weight: 600;">{{ $projet->compte->ville ?? 'Non renseignée' }}</span>
                            </div>
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Quartier</span>
                                <span style="color: #2d3748; font-weight: 600;">{{ $projet->compte->quartier ?? 'Non renseigné' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions rapides --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Actions</h3>
                    
                    <div style="display: grid; gap: 12px;">
                        @if($projet->status === 'frais_en_attente' && !$projet->frais_etude_paye)
                        <a href="{{ route('confirmer_paiement', $projet->id) }}" 
                            style="background: #10b981; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Confirmer Paiement
                        </a>
                        @endif

                        @if($projet->status === 'frais_en_attente' && $projet->frais_etude_paye)
                        <a href="{{ route('financement.etudier', $projet->id) }}" 
                            style="background: #4299e1; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Étudier le Projet
                        </a>
                        @endif

                        @if($projet->status === 'en_etude')
                        <a href="{{ route('financement.evaluer', $projet->id) }}" 
                            style="background: #9f7aea; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Évaluer et Décider
                        </a>
                        @endif

                        @if($projet->status === 'approuve')
                        <a href="{{ route('financement.financer', $projet->id) }}" 
                            style="background: #48bb78; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Finaliser Financement
                        </a>
                        @endif

                        @if(in_array($projet->status, ['finance', 'en_cours']))
                        <a href="{{ route('suivi', $projet->id) }}" 
                            style="background: #f59e0b; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Suivi du Projet
                        </a>
                        @endif

                        <a href="#" 
                            style="background: #48bb78; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Contacter Client
                        </a>

                        <a href="#" 
                            style="background: #9f7aea; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Générer Rapport
                        </a>

                        <a href="#" 
                            style="background: #ed8936; color: white; padding: 12px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
                            Historique Complet
                        </a>
                    </div>
                </div>

                {{-- Formulaire d'ajout d'observations --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Ajouter une Observation</h3>
                    
                    <form method="POST" action="#">
                        @csrf
                        
                        <div style="margin-bottom: 15px;">
                            <textarea name="observations" rows="4" required placeholder="Ajouter une note, observation ou commentaire sur ce projet..."
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
                        </div>

                        <button type="submit" 
                            style="width: 100%; background: #4299e1; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                            Ajouter Observation
                        </button>
                    </form>
                </div>

                {{-- Chronologie du projet --}}
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Chronologie</h3>
                    
                    @if($projet->historique_status && count($projet->historique_status) > 0)
                    <div style="position: relative;">
                        {{-- Ligne verticale --}}
                        <div style="position: absolute; left: 12px; top: 0; bottom: 0; width: 2px; background: #e2e8f0;"></div>
                        
                        <div style="display: grid; gap: 20px;">
                            @foreach(array_reverse($projet->historique_status) as $index => $historique)
                            <div style="position: relative; padding-left: 40px;">
                                {{-- Point sur la timeline --}}
                                <div style="position: absolute; left: 6px; top: 3px; width: 12px; height: 12px; background: #4299e1; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 2px #4299e1;"></div>
                                
                                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                                    <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px; font-size: 0.95rem;">
                                        {{ $historique['note'] ?? 'Action effectuée' }}
                                    </div>
                                    <div style="color: #718096; font-size: 0.85rem; margin-bottom: 5px;">
                                        {{ \Carbon\Carbon::parse($historique['date'])->format('d/m/Y à H:i') }}
                                    </div>
                                    @if(isset($historique['traite_par']))
                                    <div style="color: #4299e1; font-size: 0.8rem;">
                                        Par {{ \App\Models\User::find($historique['traite_par'])->name ?? 'Gestionnaire' }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div style="text-align: center; padding: 20px; color: #718096;">
                        <div style="font-size: 2rem; margin-bottom: 10px;">📝</div>
                        <div>Aucun historique disponible</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Conditions de remboursement si financé --}}
        @if($projet->status === 'finance' && $projet->conditions_remboursement)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Conditions de Remboursement</h3>
            
            <div style="background: #f0fff4; padding: 20px; border-radius: 8px; border-left: 4px solid #10b981;">
                <div style="color: #166534; line-height: 1.6; white-space: pre-line;">{{ $projet->conditions_remboursement }}</div>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection