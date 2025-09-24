@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1000px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Étude du Business Plan</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">Projet: {{ $projet->nom_projet }} - FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('projet.dashboard') }}" 
                    style="background: #a0aec0; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px;">
            {{-- Informations détaillées du projet --}}
            <div>
                {{-- Détails du projet --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations du Projet</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                        <div>
                            <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Secteur d'Activité</div>
                            <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($projet->secteur_activite) }}</div>
                        </div>
                        <div>
                            <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Montant Total Projet</div>
                            <div style="color: #2d3748; font-weight: 600;">{{ number_format($projet->montant_total_projet, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div>
                            <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Financement Demandé</div>
                            <div style="color: #4299e1; font-weight: 600;">{{ number_format($projet->montant_financement_demande, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div>
                            <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Apport Personnel</div>
                            <div style="color: #48bb78; font-weight: 600;">{{ number_format($projet->apport_personnel, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div>
                            <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Durée Souhaitée</div>
                            <div style="color: #2d3748; font-weight: 600;">{{ $projet->duree_remboursement }} mois</div>
                        </div>
                        <div>
                            <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Emplois Prévus</div>
                            <div style="color: #2d3748; font-weight: 600;">{{ $projet->employes_prevus ?? 'Non spécifié' }}</div>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <h4 style="color: #2d3748; margin: 0 0 10px 0;">Description du Projet</h4>
                        <div style="background: #f7fafc; padding: 15px; border-radius: 8px; line-height: 1.6; color: #2d3748;">
                            {{ $projet->description_projet }}
                        </div>
                    </div>

                    @if($projet->nature_apport)
                    <div>
                        <h4 style="color: #2d3748; margin: 0 0 10px 0;">Nature de l'Apport Personnel</h4>
                        <div style="background: #f0fff4; padding: 15px; border-radius: 8px; line-height: 1.6; color: #2d3748; border-left: 4px solid #48bb78;">
                            {{ $projet->nature_apport }}
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Objectifs --}}
                @if($projet->objectifs_court_terme || $projet->objectifs_long_terme)
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Objectifs du Projet</h3>
                    
                    @if($projet->objectifs_court_terme)
                    <div style="margin-bottom: 20px;">
                        <h4 style="color: #4299e1; margin: 0 0 10px 0;">Objectifs à Court Terme</h4>
                        <div style="background: #ebf8ff; padding: 15px; border-radius: 8px; line-height: 1.6; color: #2d3748; border-left: 4px solid #4299e1;">
                            {{ $projet->objectifs_court_terme }}
                        </div>
                    </div>
                    @endif

                    @if($projet->objectifs_long_terme)
                    <div>
                        <h4 style="color: #9f7aea; margin: 0 0 10px 0;">Objectifs à Long Terme</h4>
                        <div style="background: #faf5ff; padding: 15px; border-radius: 8px; line-height: 1.6; color: #2d3748; border-left: 4px solid #9f7aea;">
                            {{ $projet->objectifs_long_terme }}
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Documents --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Documents Fournis</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        @if($projet->business_plan)
                        <a href="{{ asset('storage/' . $projet->business_plan) }}" target="_blank"
                            style="background: #4299e1; color: white; padding: 15px; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
                            <div style="font-size: 1.5rem; margin-bottom: 5px;">📊</div>
                            <div style="font-weight: 600;">Business Plan</div>
                        </a>
                        @endif

                        @if($projet->photocopie_cni)
                        <a href="{{ asset('storage/' . $projet->photocopie_cni) }}" target="_blank"
                            style="background: #48bb78; color: white; padding: 15px; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
                            <div style="font-size: 1.5rem; margin-bottom: 5px;">🆔</div>
                            <div style="font-weight: 600;">CNI</div>
                        </a>
                        @endif

                        @if($projet->plan_localisation)
                        <a href="{{ asset('storage/' . $projet->plan_localisation) }}" target="_blank"
                            style="background: #ed8936; color: white; padding: 15px; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
                            <div style="font-size: 1.5rem; margin-bottom: 5px;">🗺️</div>
                            <div style="font-weight: 600;">Plan Localisation</div>
                        </a>
                        @endif

                        @if($projet->attestation_niu)
                        <a href="{{ asset('storage/' . $projet->attestation_niu) }}" target="_blank"
                            style="background: #9f7aea; color: white; padding: 15px; border-radius: 8px; text-decoration: none; text-align: center; transition: all 0.3s;">
                            <div style="font-size: 1.5rem; margin-bottom: 5px;">📜</div>
                            <div style="font-weight: 600;">Attestation NIU</div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar - Informations client et formulaire --}}
            <div>
                {{-- Informations client --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations Client</h3>
                    
                    <div style="text-align: center; margin-bottom: 20px;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; color: white; font-size: 2rem; font-weight: 700;">
                            {{ substr($projet->compte->nom, 0, 1) }}{{ substr($projet->compte->prenom, 0, 1) }}
                        </div>
                        <div style="font-weight: 600; color: #2d3748; font-size: 1.1rem;">{{ $projet->compte->nom }} {{ $projet->compte->prenom }}</div>
                        <div style="color: #718096; font-size: 0.9rem;">{{ $projet->compte->telephone }}</div>
                    </div>

                    <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 10px;">
                            <span style="color: #718096; font-size: 0.9rem;">Expérience dans le domaine</span>
                            <span style="color: #2d3748; font-weight: 600; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $projet->experience_domaine) }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 10px;">
                            <span style="color: #718096; font-size: 0.9rem;">Date de demande</span>
                            <span style="color: #2d3748; font-weight: 600;">{{ $projet->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div style="display: flex; justify-content: between; align-items: center;">
                            <span style="color: #718096; font-size: 0.9rem;">Frais payés le</span>
                            <span style="color: #48bb78; font-weight: 600;">{{ $projet->date_paiement_frais ? \Carbon\Carbon::parse($projet->date_paiement_frais)->format('d/m/Y') : 'En attente' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Formulaire pour marquer en étude --}}
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Commencer l'Étude</h3>
                    
                    <form method="POST" action="{{ route('marquer_en_etude', $projet->id) }}">
                        @csrf
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Délai d'étude (jours) *
                            </label>
                            <select name="delai_etude_jours" required
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner un délai</option>
                                <option value="3">3 jours (Express)</option>
                                <option value="7" selected>7 jours (Standard)</option>
                                <option value="14">14 jours (Approfondi)</option>
                                <option value="21">21 jours (Complexe)</option>
                                <option value="30">30 jours (Très complexe)</option>
                            </select>
                            @error('delai_etude_jours')
                            <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Observations initiales (optionnel)
                            </label>
                            <textarea name="observations_etude" rows="4" placeholder="Notes sur les premiers éléments identifiés, points à approfondir..."
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;">{{ old('observations_etude') }}</textarea>
                            @error('observations_etude')
                            <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="background: #dbeafe; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <h4 style="color: #1e40af; margin: 0 0 10px 0; font-size: 1rem;">Prochaines étapes</h4>
                            <ul style="color: #1e3a8a; margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                <li>Analyse détaillée du business plan</li>
                                <li>Évaluation de la viabilité financière</li>
                                <li>Vérification des documents fournis</li>
                                <li>Prise de décision d'approbation</li>
                            </ul>
                        </div>

                        <button type="submit" 
                            style="width: 100%; background: #4299e1; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                            Commencer l'Étude
                        </button>
                    </form>
                </div>

                {{-- Historique --}}
                @if($projet->historique_status && count($projet->historique_status) > 0)
                <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Historique</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach(array_reverse($projet->historique_status) as $historique)
                        <div style="display: flex; gap: 15px; padding: 15px; background: #f7fafc; border-radius: 8px; border-left: 4px solid #4299e1;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; font-size: 0.9rem; margin-bottom: 5px;">
                                    {{ $historique['note'] ?? 'Action effectuée' }}
                                </div>
                                <div style="color: #718096; font-size: 0.8rem;">
                                    {{ \Carbon\Carbon::parse($historique['date'])->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection