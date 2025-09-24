{{-- resources/views/import/export/status.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 2rem; font-weight: 700;">Mes Commandes Import/Export</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Suivez vos importations de Chine</p>
                </div>
                <a href="#" 
                    style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Nouvelle Demande
                </a>
            </div>
        </div>

        @if($demandes->count() > 0)
            {{-- Statistiques --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                @php
                $totalDemandes = $demandes->count();
                $demandesEnCours = $demandes->whereIn('status', ['en_attente', 'recherche_en_cours', 'devis_envoye', 'attente_confirmation', 'commande_confirmee', 'paiement_recu', 'achat_en_cours', 'expedition', 'en_transit', 'arrivee', 'dedouanement'])->count();
                $demandesLivrees = $demandes->where('status', 'livre')->count();
                $montantTotalCommandes = $demandes->sum('prix_total_marchandise');
                @endphp

                <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; margin-bottom: 5px;">{{ $totalDemandes }}</div>
                    <div style="opacity: 0.9;">Demandes Total</div>
                </div>

                <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; margin-bottom: 5px;">{{ $demandesEnCours }}</div>
                    <div style="opacity: 0.9;">En Cours</div>
                </div>

                <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; margin-bottom: 5px;">{{ $demandesLivrees }}</div>
                    <div style="opacity: 0.9;">Livrées</div>
                </div>

                <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 1.2rem; font-weight: 700; margin-bottom: 5px;">{{ number_format($montantTotalCommandes, 0, ',', ' ') }}</div>
                    <div style="opacity: 0.9;">Total Payé (FCFA)</div>
                </div>
            </div>

            {{-- Liste des demandes --}}
            <div style="display: grid; gap: 25px;">
                @foreach($demandes as $demande)
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    
                    {{-- En-tête de la demande --}}
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                                <h3 style="color: #2d3748; margin: 0; font-size: 1.4rem; font-weight: 700;">{{ $demande->nom_marchandise }}</h3>
                                <span style="background: #e2e8f0; color: #4a5568; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                    {{ $demande->numero_reference }}
                                </span>
                            </div>
                            <p style="color: #718096; margin: 0; font-size: 0.9rem;">
                                {{ ucfirst($demande->categorie) }} • 
                                {{ $demande->quantite_finale ?? $demande->quantite_souhaitee }} {{ $demande->unite_mesure }} • 
                                Créée le {{ $demande->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <div style="text-align: right;">
                            @php
                            $statusStyles = [
                                'en_attente' => 'background: #fef3c7; color: #92400e;',
                                'recherche_en_cours' => 'background: #dbeafe; color: #1d4ed8;',
                                'devis_envoye' => 'background: #e0e7ff; color: #3730a3;',
                                'attente_confirmation' => 'background: #fef3c7; color: #92400e;',
                                'commande_confirmee' => 'background: #dcfce7; color: #166534;',
                                'paiement_recu' => 'background: #dcfce7; color: #166534;',
                                'achat_en_cours' => 'background: #e0f2fe; color: #0c4a6e;',
                                'expedition' => 'background: #e0f2fe; color: #0c4a6e;',
                                'en_transit' => 'background: #e0f2fe; color: #0c4a6e;',
                                'arrivee' => 'background: #f0f9ff; color: #1e40af;',
                                'dedouanement' => 'background: #f0f9ff; color: #1e40af;',
                                'pret_livraison' => 'background: #dcfce7; color: #166534;',
                                'livre' => 'background: #dcfce7; color: #166534;',
                                'annule' => 'background: #fecaca; color: #991b1b;',
                                'probleme' => 'background: #fecaca; color: #991b1b;'
                            ];
                            $statusLabels = [
                                'en_attente' => 'En Attente',
                                'recherche_en_cours' => 'Recherche en cours',
                                'devis_envoye' => 'Devis Reçu',
                                'attente_confirmation' => 'Attente Confirmation',
                                'commande_confirmee' => 'Commande Confirmée',
                                'paiement_recu' => 'Paiement Reçu',
                                'achat_en_cours' => 'Achat en Cours',
                                'expedition' => 'Expédition',
                                'en_transit' => 'En Transit',
                                'arrivee' => 'Arrivée',
                                'dedouanement' => 'Dédouanement',
                                'pret_livraison' => 'Prêt Livraison',
                                'livre' => 'Livré',
                                'annule' => 'Annulé',
                                'probleme' => 'Problème'
                            ];
                            @endphp
                            <span style="padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; {{ $statusStyles[$demande->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                                {{ $statusLabels[$demande->status] ?? 'Inconnu' }}
                            </span>
                        </div>
                    </div>

                    {{-- Contenu principal --}}
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 20px;">
                        
                        {{-- Informations principales --}}
                        <div>
                            <h4 style="color: #4a5568; margin: 0 0 10px 0; font-size: 1rem;">Description</h4>
                            <p style="color: #2d3748; margin: 0 0 15px 0; line-height: 1.6; font-size: 0.95rem;">
                                {{ Str::limit($demande->description_marchandise, 200) }}
                            </p>
                            
                            @if($demande->exigences_particulieres)
                            <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <h5 style="color: #1e40af; margin: 0 0 8px 0; font-size: 0.9rem;">Exigences Particulières</h5>
                                <p style="color: #1e3a8a; margin: 0; font-size: 0.85rem;">{{ $demande->exigences_particulieres }}</p>
                            </div>
                            @endif

                            {{-- DEVIS REÇU --}}
                            @if($demande->status == 'devis_envoye' && $demande->prix_unitaire_propose)
                            <div style="background: #f0f9ff; border: 2px solid #3b82f6; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                                <h5 style="color: #1e40af; margin: 0 0 15px 0; font-size: 1.1rem; font-weight: 700;">📋 Devis Reçu</h5>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                    <div>
                                        <div style="color: #1e3a8a; font-size: 0.9rem;">Prix Unitaire</div>
                                        <div style="color: #1e40af; font-weight: 700; font-size: 1.1rem;">{{ number_format($demande->prix_unitaire_propose, 0, ',', ' ') }} FCFA</div>
                                    </div>
                                    <div>
                                        <div style="color: #1e3a8a; font-size: 0.9rem;">Quantité</div>
                                        <div style="color: #1e40af; font-weight: 700; font-size: 1.1rem;">{{ $demande->quantite_finale }} {{ $demande->unite_mesure }}</div>
                                    </div>
                                    <div>
                                        <div style="color: #1e3a8a; font-size: 0.9rem;">Prix Total</div>
                                        <div style="color: #15803d; font-weight: 700; font-size: 1.2rem;">{{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA</div>
                                    </div>
                                    <div>
                                        <div style="color: #1e3a8a; font-size: 0.9rem;">Poids Estimé</div>
                                        <div style="color: #1e40af; font-weight: 700; font-size: 1.1rem;">{{ $demande->poids_estime_kg }} kg</div>
                                    </div>
                                </div>

                                @if($demande->details_devis)
                                <div style="background: rgba(255,255,255,0.7); padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                    <h6 style="color: #1e40af; margin: 0 0 8px 0;">Détails du produit</h6>
                                    <p style="color: #1e3a8a; margin: 0; line-height: 1.5; font-size: 0.9rem;">{{ $demande->details_devis }}</p>
                                </div>
                                @endif

                                {{-- Frais supplémentaires --}}
                                <div style="background: #fef3c7; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                    <h6 style="color: #92400e; margin: 0 0 10px 0;">Frais supplémentaires (à payer à l'arrivée)</h6>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="color: #78350f;">Frais de douane ({{ $demande->poids_estime_kg }} kg × 10,000):</span>
                                        <span style="color: #92400e; font-weight: 600;">{{ number_format($demande->frais_douane_estimes, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="color: #78350f;">Commission AXE CAPITAL ({{ $demande->poids_estime_kg }} kg × 1,000):</span>
                                        <span style="color: #92400e; font-weight: 600;">{{ number_format($demande->commission_axe_capital, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <hr style="border: none; border-top: 1px solid #d97706; margin: 10px 0;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #92400e; font-weight: 700;">Total à l'arrivée:</span>
                                        <span style="color: #92400e; font-weight: 700;">{{ number_format($demande->frais_douane_estimes + $demande->commission_axe_capital, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                </div>

                                <div style="text-align: center;">
                                    <a href="{{route('confirm', $demande->id)}}" 
                                        style="background: #15803d; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-right: 10px;">
                                        ✓ Accepter le Devis
                                    </a>
                                    <a href="{{route('rejecter',$demande->id)}}" 
                                        style="background: #dc2626; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                                        ✗ Rejeter
                                    </a>
                                </div>
                            </div>
                            @endif

                            {{-- PAIEMENT REQUIS --}}
                            @if($demande->status == 'commande_confirmee' && !$demande->montant_paye_marchandise)
                            <div style="background: #fef3c7; border: 2px solid #f59e0b; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                                <h5 style="color: #92400e; margin: 0 0 15px 0; font-size: 1.1rem; font-weight: 700;">💳 Paiement Requis</h5>
                                <p style="color: #78350f; margin: 0 0 15px 0;">
                                    Veuillez effectuer le paiement de <strong>{{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA</strong> 
                                    pour que nous puissions procéder à l'achat de votre marchandise.
                                </p>
                                <div style="text-align: center;">
                                    <a href="#" 
                                        style="background: #15803d; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                                        Effectuer le Paiement
                                    </a>
                                </div>
                            </div>
                            @endif

                            {{-- SUIVI D'EXPÉDITION --}}
                            @if($demande->numero_suivi || $demande->informations_suivi)
                            <div style="background: #e0f2fe; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <h5 style="color: #0c4a6e; margin: 0 0 10px 0; font-size: 1rem;">🚢 Suivi de l'Expédition</h5>
                                @if($demande->numero_suivi)
                                <div style="margin-bottom: 10px;">
                                    <strong style="color: #0c4a6e;">Numéro de suivi:</strong> 
                                    <span style="color: #0369a1; font-weight: 600;">{{ $demande->numero_suivi }}</span>
                                </div>
                                @endif
                                @if($demande->informations_suivi)
                                <div style="background: rgba(255,255,255,0.7); padding: 10px; border-radius: 6px;">
                                    <p style="color: #0c4a6e; margin: 0; font-size: 0.9rem;">{{ $demande->informations_suivi }}</p>
                                </div>
                                @endif
                            </div>
                            @endif

                            {{-- OBSERVATIONS AXE CAPITAL --}}
                            @if($demande->observations)
                            <div style="background: #f0f9ff; color: #1e40af; padding: 15px; border-radius: 8px; margin-top: 15px;">
                                <strong>💬 Message AXE CAPITAL:</strong> {{ $demande->observations }}
                            </div>
                            @endif
                        </div>

                        {{-- Détails financiers et livraison --}}
                        <div style="background: #f7fafc; padding: 20px; border-radius: 10px;">
                            <h4 style="color: #4a5568; margin: 0 0 15px 0; font-size: 1rem;">Détails de la Commande</h4>
                            
                            <div style="margin-bottom: 12px;">
                                <div style="color: #718096; font-size: 0.85rem;">Quantité</div>
                                <div style="color: #2d3748; font-weight: 600;">
                                    {{ $demande->quantite_finale ?? $demande->quantite_souhaitee }} {{ $demande->unite_mesure }}
                                </div>
                            </div>

                            @if($demande->prix_total_marchandise)
                            <div style="margin-bottom: 12px;">
                                <div style="color: #718096; font-size: 0.85rem;">Prix Marchandise</div>
                                <div style="color: #15803d; font-weight: 600; font-size: 1.1rem;">
                                    {{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA
                                    @if($demande->montant_paye_marchandise)
                                    <span style="color: #10b981; font-size: 0.8rem;">✓ Payé</span>
                                    @else
                                    <span style="color: #ef4444; font-size: 0.8rem;">En attente</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($demande->poids_estime_kg || $demande->poids_final_kg)
                            <div style="margin-bottom: 12px;">
                                <div style="color: #718096; font-size: 0.85rem;">Poids</div>
                                <div style="color: #2d3748; font-weight: 600;">
                                    {{ $demande->poids_final_kg ?? $demande->poids_estime_kg }} kg
                                </div>
                            </div>
                            @endif

                            <div style="margin-bottom: 12px;">
                                <div style="color: #718096; font-size: 0.85rem;">Livraison</div>
                                <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">
                                    {{ ucfirst($demande->lieu_livraison) }}
                                </div>
                                @if($demande->ville_livraison)
                                <div style="color: #718096; font-size: 0.8rem;">{{ $demande->ville_livraison }}</div>
                                @endif
                            </div>

                            @if($demande->mode_expedition_final || $demande->mode_expedition)
                            <div style="margin-bottom: 12px;">
                                <div style="color: #718096; font-size: 0.85rem;">Mode d'Expédition</div>
                                <div style="color: #2d3748; font-weight: 600;">
                                    {{ ucfirst($demande->mode_expedition_final ?? $demande->mode_expedition ?? 'Non défini') }}
                                </div>
                            </div>
                            @endif

                            {{-- Dates importantes --}}
                            @if($demande->date_expedition || $demande->date_arrivee_prevue)
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                                <h5 style="color: #4a5568; margin: 0 0 10px 0; font-size: 0.9rem;">Dates Importantes</h5>
                                @if($demande->date_expedition)
                                <div style="margin-bottom: 8px;">
                                    <div style="color: #718096; font-size: 0.8rem;">Expédition</div>
                                    <div style="color: #2d3748; font-weight: 600; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($demande->date_expedition)->format('d/m/Y') }}</div>
                                </div>
                                @endif
                                @if($demande->date_arrivee_prevue)
                                <div style="margin-bottom: 8px;">
                                    <div style="color: #718096; font-size: 0.8rem;">Arrivée Prévue</div>
                                    <div style="color: #f59e0b; font-weight: 600; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($demande->date_arrivee_prevue)->format('d/m/Y') }}</div>
                                </div>
                                @endif
                            </div>
                            @endif

                            {{-- Frais à régler à l'arrivée --}}
                            @if(in_array($demande->status, ['arrivee', 'dedouanement', 'pret_livraison']) && ($demande->frais_douane_reels || $demande->commission_finale))
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                                <h5 style="color: #dc2626; margin: 0 0 10px 0; font-size: 0.9rem; font-weight: 700;">⚠️ Frais à Régler</h5>
                                @if($demande->frais_douane_reels)
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 0.85rem; color: #718096;">Douane:</span>
                                    <span style="font-weight: 600; color: {{ $demande->frais_douane_payes ? '#10b981' : '#ef4444' }};">
                                        {{ number_format($demande->frais_douane_reels, 0, ',', ' ') }} FCFA
                                        @if($demande->frais_douane_payes) ✓ @endif
                                    </span>
                                </div>
                                @endif
                                @if($demande->commission_finale)
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 0.85rem; color: #718096;">Commission:</span>
                                    <span style="font-weight: 600; color: {{ $demande->commission_payee ? '#10b981' : '#ef4444' }};">
                                        {{ number_format($demande->commission_finale, 0, ',', ' ') }} FCFA
                                        @if($demande->commission_payee) ✓ @endif
                                    </span>
                                </div>
                                @endif
                                <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 8px 0;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-weight: 700; color: #dc2626; font-size: 0.9rem;">Total:</span>
                                    <span style="font-weight: 700; color: #dc2626;">{{ number_format(($demande->frais_douane_reels ?? 0) + ($demande->commission_finale ?? 0), 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Barre de progression --}}
                    @php
                    $progressSteps = [
                        'en_attente' => 1,
                        'recherche_en_cours' => 2,
                        'devis_envoye' => 3,
                        'attente_confirmation' => 3,
                        'commande_confirmee' => 4,
                        'paiement_recu' => 5,
                        'achat_en_cours' => 6,
                        'expedition' => 7,
                        'en_transit' => 8,
                        'arrivee' => 9,
                        'dedouanement' => 10,
                        'pret_livraison' => 11,
                        'livre' => 12
                    ];
                    $currentStep = $progressSteps[$demande->status] ?? 1;
                    $totalSteps = 12;
                    $progressPercent = ($currentStep / $totalSteps) * 100;
                    @endphp

                    @if(!in_array($demande->status, ['annule', 'probleme']))
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <h4 style="color: #4a5568; margin: 0; font-size: 0.9rem;">Progression de la Commande</h4>
                            <span style="color: #718096; font-size: 0.8rem;">{{ round($progressPercent) }}% complété</span>
                        </div>
                        
                        <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div style="background: linear-gradient(90deg, #4299e1, #10b981); height: 100%; width: {{ $progressPercent }}%; transition: width 0.5s ease;"></div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 5px; margin-top: 15px; font-size: 0.7rem; text-align: center;">
                            <div style="color: {{ $currentStep >= 2 ? '#4299e1' : '#a0aec0' }};">
                                <div style="margin-bottom: 3px;">🔍</div>
                                Recherche
                            </div>
                            <div style="color: {{ $currentStep >= 4 ? '#4299e1' : '#a0aec0' }};">
                                <div style="margin-bottom: 3px;">✅</div>
                                Confirmation
                            </div>
                            <div style="color: {{ $currentStep >= 6 ? '#4299e1' : '#a0aec0' }};">
                                <div style="margin-bottom: 3px;">🛒</div>
                                Achat
                            </div>
                            <div style="color: {{ $currentStep >= 8 ? '#4299e1' : '#a0aec0' }};">
                                <div style="margin-bottom: 3px;">🚢</div>
                                Transit
                            </div>
                            <div style="color: {{ $currentStep >= 10 ? '#4299e1' : '#a0aec0' }};">
                                <div style="margin-bottom: 3px;">🏛️</div>
                                Douane
                            </div>
                            <div style="color: {{ $currentStep >= 12 ? '#10b981' : '#a0aec0' }};">
                                <div style="margin-bottom: 3px;">📦</div>
                                Livraison
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Actions et dates importantes --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <div style="color: #718096; font-size: 0.85rem;">
                            @if($demande->date_livraison)
                            Livré le {{ \Carbon\Carbon::parse($demande->date_livraison)->format('d/m/Y') }}
                            @elseif($demande->date_arrivee_effective)
                            Arrivé le {{ \Carbon\Carbon::parse($demande->date_arrivee_effective)->format('d/m/Y') }}
                            @elseif($demande->date_expedition)
                            Expédié le {{ \Carbon\Carbon::parse($demande->date_expedition)->format('d/m/Y') }}
                            @elseif($demande->date_devis)
                            Devis envoyé le {{ \Carbon\Carbon::parse($demande->date_devis)->format('d/m/Y') }}
                            @else
                            Créé le {{ $demande->created_at->format('d/m/Y') }}
                            @endif
                        </div>
                        
                        <div style="display: flex; gap: 10px;">
                            {{-- Actions spécifiques selon le statut --}}
                            @if($demande->status == 'devis_envoye')
                            <a href="{{route('confirm', $demande->id)}}" 
                                style="background: #15803d; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                                Accepter Devis
                            </a>
                            @endif

                            @if($demande->status == 'commande_confirmee' && !$demande->montant_paye_marchandise)
                            <a href="#" 
                                style="background: #f59e0b; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                                Payer
                            </a>
                            @endif

                            @if($demande->photos_marchandise && count($demande->photos_marchandise) > 0)
                            <button onclick="togglePhotos{{ $demande->id }}()" 
                                style="background: #8b5cf6; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                Photos ({{ count($demande->photos_marchandise) }})
                            </button>
                            @endif
                            
                            <a href="#" 
                                style="background: #4299e1; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                                Détails Complets
                            </a>
                        </div>
                    </div>

                    {{-- Photos (masquées par défaut) --}}
                    @if($demande->photos_marchandise && count($demande->photos_marchandise) > 0)
                    <div id="photos{{ $demande->id }}" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                        <h5 style="color: #4a5568; margin: 0 0 15px 0;">Photos de la Marchandise</h5>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                            @foreach($demande->photos_marchandise as $index => $photo)
                            <div style="border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Photo {{ $index + 1 }}" 
                                     style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;" 
                                     onclick="window.open('{{ asset('storage/' . $photo) }}', '_blank')">
                                <div style="padding: 8px; background: #f7fafc; text-align: center; font-size: 0.8rem; color: #4a5568;">
                                    Photo {{ $index + 1 }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <script>
                        function togglePhotos{{ $demande->id }}() {
                            const photosDiv = document.getElementById('photos{{ $demande->id }}');
                            if (photosDiv.style.display === 'none') {
                                photosDiv.style.display = 'block';
                            } else {
                                photosDiv.style.display = 'none';
                            }
                        }
                    </script>
                    @endif
                </div>
                @endforeach
            </div>

        @else
            {{-- État vide --}}
            <div style="background: white; border-radius: 15px; padding: 60px 30px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 20px;">🚢</div>
                <h3 style="color: #2d3748; margin: 0 0 15px 0; font-size: 1.4rem;">Aucune Commande Import/Export</h3>
                <p style="color: #718096; margin: 0 0 30px 0; line-height: 1.6;">
                    Vous n'avez encore effectué aucune demande d'importation.<br>
                    Commencez dès maintenant et importez vos produits de Chine !
                </p>
                <a href="#" 
                    style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block;">
                    Ma Première Importation
                </a>
            </div>
        @endif

        {{-- Aide et support --}}
        <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 15px; padding: 25px; margin-top: 30px; text-align: center;">
            <h3 style="margin: 0 0 15px 0;">Questions sur Votre Commande ?</h3>
            <p style="margin: 0 0 20px 0; opacity: 0.9;">
                Contactez-nous via WhatsApp pour un suivi personnalisé de votre importation.
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="https://wa.me/237688822232" target="_blank"
                    style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; backdrop-filter: blur(10px);">
                    WhatsApp Support
                </a>
                <a href="mailto:import@axecapital.com" 
                    style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; backdrop-filter: blur(10px);">
                    Email Support
                </a>
            </div>
        </div>
    </div>
</section>

@endsection