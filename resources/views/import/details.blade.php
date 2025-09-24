{{-- resources/views/gestionnaire/import-export/details.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Détails de la Demande {{ $demande->numero_reference }}</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $demande->nom_marchandise }}</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    @if($demande->status == 'en_attente')
                    <a href="{{ route('traiter', $demande->id) }}" style="background: #48bb78; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Traiter
                    </a>
                    @endif
                    @if(in_array($demande->status, ['recherche_en_cours', 'devis_envoye']))
                    <a href="{{ route('devis', $demande->id) }}" style="background: #4299e1; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Devis
                    </a>
                    @endif
                    <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        {{-- Statut actuel --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h3 style="margin: 0; color: #2d3748;">Statut actuel</h3>
                </div>
                <div>
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
                        'recherche_en_cours' => 'Recherche en Cours',
                        'devis_envoye' => 'Devis Envoyé',
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
                    <span style="padding: 12px 24px; border-radius: 25px; font-size: 1.1rem; font-weight: 600; {{ $statusStyles[$demande->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                        {{ $statusLabels[$demande->status] ?? 'Inconnu' }}
                    </span>
                </div>
            </div>
            
            @if($demande->date_traitement)
            <p style="margin: 15px 0 0 0; color: #718096;">
                Traité le: {{ \Carbon\Carbon::parse($demande->date_traitement)->format('d/m/Y à H:i') }}
            </p>
            @endif
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            {{-- Informations client --}}
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations Client</h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                       
                    <div>
                        <strong style="color: #4a5568;">Email:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $demande->compte->email ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Téléphone:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $demande->telephone_livraison }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Lieu de livraison:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; text-transform: capitalize;">{{ ucfirst($demande->lieu_livraison) }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Ville:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $demande->ville_livraison }}</p>
                    </div>
                    @if($demande->adresse_livraison)
                    <div>
                        <strong style="color: #4a5568;">Adresse:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $demande->adresse_livraison }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Détails de la marchandise --}}
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Détails Marchandise</h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <strong style="color: #4a5568;">Produit:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; font-size: 1.1rem; font-weight: 600;">{{ $demande->nom_marchandise }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Catégorie:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; text-transform: capitalize;">{{ ucfirst($demande->categorie) }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Quantité:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $demande->quantite_finale ?? $demande->quantite_souhaitee }} {{ $demande->unite_mesure }}</p>
                    </div>
                    @if($demande->budget_approximatif)
                    <div>
                        <strong style="color: #4a5568;">Budget client:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ number_format($demande->budget_approximatif, 0, ',', ' ') }} FCFA</p>
                    </div>
                    @endif
                    <div>
                        <strong style="color: #4a5568;">Mode expédition:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; text-transform: capitalize;">{{ $demande->mode_expedition_final ?? $demande->mode_expedition ?? 'Non spécifié' }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Urgence:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; text-transform: capitalize;">{{ ucfirst($demande->urgence) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description et exigences --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Description et Exigences</h3>
            
            <div style="margin-bottom: 25px;">
                <h4 style="color: #4a5568; margin: 0 0 15px 0;">Description du produit</h4>
                <div style="background: #f7fafc; padding: 20px; border-radius: 8px; line-height: 1.6;">
                    {{ $demande->description_marchandise }}
                </div>
            </div>

            @if($demande->exigences_particulieres)
            <div style="margin-bottom: 25px;">
                <h4 style="color: #4a5568; margin: 0 0 15px 0;">Exigences particulières</h4>
                <div style="background: #f0f9ff; padding: 20px; border-radius: 8px; line-height: 1.6; color: #1e3a8a;">
                    {{ $demande->exigences_particulieres }}
                </div>
            </div>
            @endif

            @if($demande->commentaires)
            <div>
                <h4 style="color: #4a5568; margin: 0 0 15px 0;">Commentaires client</h4>
                <div style="background: #fef3c7; padding: 20px; border-radius: 8px; line-height: 1.6; color: #78350f;">
                    {{ $demande->commentaires }}
                </div>
            </div>
            @endif
        </div>

        {{-- Photos de la marchandise --}}
        @if($demande->photos_marchandise && count($demande->photos_marchandise) > 0)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Photos de la Marchandise</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                @foreach($demande->photos_marchandise as $index => $photo)
                <div style="background: #f7fafc; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Photo {{ $index + 1 }}" 
                         style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;" 
                         onclick="window.open('{{ asset('storage/' . $photo) }}', '_blank')">
                    <div style="padding: 12px; text-align: center;">
                        <span style="color: #4a5568; font-weight: 600;">Photo {{ $index + 1 }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Informations financières --}}
        @if($demande->prix_total_marchandise || $demande->frais_douane_estimes)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations Financières</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                @if($demande->prix_unitaire_propose)
                <div style="background: #e0f2fe; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Prix Unitaire</div>
                    <div style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">{{ number_format($demande->prix_unitaire_propose, 0, ',', ' ') }} FCFA</div>
                </div>
                @endif

                @if($demande->prix_total_marchandise)
                <div style="background: #dcfce7; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #166534; font-size: 0.9rem; margin-bottom: 5px;">Total Marchandise</div>
                    <div style="color: #15803d; font-weight: 700; font-size: 1.2rem;">{{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA</div>
                </div>
                @endif

                @if($demande->poids_estime_kg || $demande->poids_final_kg)
                <div style="background: #f3e8ff; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #553c9a; font-size: 0.9rem; margin-bottom: 5px;">Poids</div>
                    <div style="color: #7c3aed; font-weight: 700; font-size: 1.2rem;">{{ $demande->poids_final_kg ?? $demande->poids_estime_kg }} kg</div>
                </div>
                @endif

                @if($demande->frais_douane_estimes || $demande->frais_douane_reels)
                <div style="background: #fef3c7; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #92400e; font-size: 0.9rem; margin-bottom: 5px;">Frais Douane</div>
                    <div style="color: #d97706; font-weight: 700; font-size: 1.2rem;">{{ number_format($demande->frais_douane_reels ?? $demande->frais_douane_estimes, 0, ',', ' ') }} FCFA</div>
                </div>
                @endif

                @if($demande->commission_axe_capital || $demande->commission_finale)
                <div style="background: #fed7d7; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #742a2a; font-size: 0.9rem; margin-bottom: 5px;">Commission AXE</div>
                    <div style="color: #dc2626; font-weight: 700; font-size: 1.2rem;">{{ number_format($demande->commission_finale ?? $demande->commission_axe_capital, 0, ',', ' ') }} FCFA</div>
                </div>
                @endif
            </div>

            @if($demande->details_devis)
            <div style="margin-top: 25px;">
                <h4 style="color: #4a5568; margin: 0 0 15px 0;">Détails du devis</h4>
                <div style="background: #f0fdf4; padding: 20px; border-radius: 8px; line-height: 1.6; color: #14532d;">
                    {{ $demande->details_devis }}
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Suivi de l'expédition --}}
        @if($demande->numero_suivi || $demande->date_expedition)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Suivi de l'Expédition</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                @if($demande->numero_commande_chine)
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">N° Commande Chine</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->numero_commande_chine }}</div>
                </div>
                @endif

                @if($demande->numero_suivi)
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">N° de Suivi</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->numero_suivi }}</div>
                </div>
                @endif

                @if($demande->date_expedition)
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Date Expédition</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ \Carbon\Carbon::parse($demande->date_expedition)->format('d/m/Y') }}</div>
                </div>
                @endif

                @if($demande->date_arrivee_prevue)
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Arrivée Prévue</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ \Carbon\Carbon::parse($demande->date_arrivee_prevue)->format('d/m/Y') }}</div>
                </div>
                @endif
            </div>

            @if($demande->informations_suivi)
            <div style="background: #f0f9ff; padding: 20px; border-radius: 8px;">
                <h4 style="color: #1e40af; margin: 0 0 10px 0;">Informations de suivi</h4>
                <p style="margin: 0; color: #1e3a8a; line-height: 1.6;">{{ $demande->informations_suivi }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- Observations --}}
        @if($demande->observations)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Observations Internes</h3>
            <div style="background: #f7fafc; padding: 20px; border-radius: 8px; line-height: 1.6;">
                {{ $demande->observations }}
            </div>
        </div>
        @endif

        {{-- Historique --}}
        @if($demande->historique_status)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Historique</h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach(array_reverse($demande->historique_status) as $historique)
                <div style="background: #f7fafc; padding: 15px; border-left: 4px solid #4299e1; border-radius: 0 8px 8px 0;">
                    <div style="display: flex; justify-content: between; align-items: start; gap: 15px;">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #2d3748;">{{ $statusLabels[$historique['status']] ?? $historique['status'] }}</div>
                            @if(isset($historique['note']) && $historique['note'])
                            <div style="color: #4a5568; margin-top: 5px;">{{ $historique['note'] }}</div>
                            @endif
                        </div>
                        <div style="text-align: right;">
                            <div style="color: #718096; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($historique['date'])->format('d/m/Y H:i') }}</div>
                            @if(isset($historique['traite_par']))
                            <div style="color: #718096; font-size: 0.8rem;">{{ $historique['traite_par'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection