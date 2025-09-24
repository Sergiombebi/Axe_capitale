@extends('layouts.home')
@section('content')
{{-- Vue de gestion des import/export pour gestionnaire_import_export --}}
<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">

@if(auth()->user()->role !== 'gest-import')
<div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin: 20px; color: #dc2626; text-align: center;">
    <h3>Accès non autorisé</h3>
    <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
</div>
@else
    <div style="max-width: 1400px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 2rem; font-weight: 700;">Dashboard Gestionnaire Import/Export</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Gestion des demandes d'importation</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="#" style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
                        Exporter
                    </a>
                    <a href="{{ route('import.export') }}" style="background: #4299e1; color: white; border: none; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
                        Actualiser
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalDemandes ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Demandes Total</p>
                    </div>
                    <div style="font-size: 2rem;">🚢</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #ed8936, #dd6b20); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $demandesEnAttente ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Attente</p>
                    </div>
                    <div style="font-size: 2rem;">⏳</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $demandesEnTransit ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Transit</p>
                    </div>
                    <div style="font-size: 2rem;">🚢</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $demandesLivrees ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Livrées</p>
                    </div>
                    <div style="font-size: 2rem;">✅</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #9f7aea, #805ad5); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ number_format($montantTotalCommandes ?? 0, 0, ',', ' ') }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Commandes (FCFA)</p>
                    </div>
                    <div style="font-size: 2rem;">💰</div>
                </div>
            </div>
        </div>

        {{-- Filtres et Recherche --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Rechercher</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, produit, référence..."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; transition: all 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Statut</label>
                    <select name="status" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                        <option value="recherche_en_cours" {{ request('status') == 'recherche_en_cours' ? 'selected' : '' }}>Recherche en cours</option>
                        <option value="devis_envoye" {{ request('status') == 'devis_envoye' ? 'selected' : '' }}>Devis envoyé</option>
                        <option value="attente_confirmation" {{ request('status') == 'attente_confirmation' ? 'selected' : '' }}>Attente confirmation</option>
                        <option value="commande_confirmee" {{ request('status') == 'commande_confirmee' ? 'selected' : '' }}>Commande confirmée</option>
                        <option value="paiement_recu" {{ request('status') == 'paiement_recu' ? 'selected' : '' }}>Paiement reçu</option>
                        <option value="achat_en_cours" {{ request('status') == 'achat_en_cours' ? 'selected' : '' }}>Achat en cours</option>
                        <option value="expedition" {{ request('status') == 'expedition' ? 'selected' : '' }}>Expédition</option>
                        <option value="en_transit" {{ request('status') == 'en_transit' ? 'selected' : '' }}>En transit</option>
                        <option value="arrivee" {{ request('status') == 'arrivee' ? 'selected' : '' }}>Arrivée</option>
                        <option value="dedouanement" {{ request('status') == 'dedouanement' ? 'selected' : '' }}>Dédouanement</option>
                        <option value="pret_livraison" {{ request('status') == 'pret_livraison' ? 'selected' : '' }}>Prêt livraison</option>
                        <option value="livre" {{ request('status') == 'livre' ? 'selected' : '' }}>Livré</option>
                        <option value="annule" {{ request('status') == 'annule' ? 'selected' : '' }}>Annulé</option>
                        <option value="probleme" {{ request('status') == 'probleme' ? 'selected' : '' }}>Problème</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Catégorie</label>
                    <select name="categorie" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Toutes catégories</option>
                        <option value="electronique" {{ request('categorie') == 'electronique' ? 'selected' : '' }}>Électronique</option>
                        <option value="vetements" {{ request('categorie') == 'vetements' ? 'selected' : '' }}>Vêtements</option>
                        <option value="chaussures" {{ request('categorie') == 'chaussures' ? 'selected' : '' }}>Chaussures</option>
                        <option value="maroquinerie" {{ request('categorie') == 'maroquinerie' ? 'selected' : '' }}>Maroquinerie</option>
                        <option value="bijoux" {{ request('categorie') == 'bijoux' ? 'selected' : '' }}>Bijoux</option>
                        <option value="cosmetique" {{ request('categorie') == 'cosmetique' ? 'selected' : '' }}>Cosmétique</option>
                        <option value="autre" {{ request('categorie') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="background: #4299e1; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1;">
                        Filtrer
                    </button>
                    <a href="{{ route('import.export') }}" style="background: #a0aec0; color: white; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: inline-block;">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tableau des demandes --}}
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="background: linear-gradient(135deg, #2d3748, #4a5568); color: white; padding: 20px;">
                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">Gestion des Demandes Import/Export</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f7fafc;">
                        <tr>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Client</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Marchandise</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Quantité/Prix</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Expédition</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Photos</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Statut</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Suivi</th>
                            <th style="padding: 15px; text-align: center; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demandes ?? [] as $demande)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f7fafc'" onmouseout="this.style.backgroundColor='white'">
                            <!-- Client -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $demande->compte->nom ?? 'N/A' }} {{ $demande->compte->prenom ?? '' }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $demande->numero_reference }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $demande->telephone_livraison ?? $demande->compte->telephone ?? 'N/A' }}</div>
                            </td>

                            <!-- Marchandise -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; font-size: 1rem; margin-bottom: 5px;">{{ $demande->nom_marchandise }}</div>
                                <div style="font-size: 0.9rem; color: #718096; text-transform: capitalize;">{{ ucfirst($demande->categorie) }}</div>
                                <div style="font-size: 0.8rem; color: #a0aec0; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $demande->description_marchandise }}">
                                    {{ Str::limit($demande->description_marchandise, 50) }}
                                </div>
                            </td>

                            <!-- Quantité/Prix -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 3px;">{{ $demande->quantite_finale ?? $demande->quantite_souhaitee }} {{ $demande->unite_mesure }}</div>
                                @if($demande->prix_total_marchandise)
                                <div style="font-size: 0.9rem; color: #4299e1; font-weight: 600;">{{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA</div>
                                @endif
                                @if($demande->poids_final_kg || $demande->poids_estime_kg)
                                <div style="font-size: 0.9rem; color: #718096;">Poids: {{ $demande->poids_final_kg ?? $demande->poids_estime_kg }} kg</div>
                                @endif
                            </td>

                            <!-- Expédition -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; text-transform: capitalize;">
                                    {{ $demande->mode_expedition_final ?? $demande->mode_expedition ?? 'Non défini' }}
                                </div>
                                <div style="font-size: 0.9rem; color: #718096; text-transform: capitalize;">{{ ucfirst($demande->lieu_livraison) }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $demande->ville_livraison }}</div>
                            </td>

                            <!-- Photos -->
                            <td style="padding: 15px;">
                                @if($demande->photos_marchandise && count($demande->photos_marchandise) > 0)
                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                    @foreach(array_slice($demande->photos_marchandise, 0, 3) as $index => $photo)
                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                                        style="background: #4299e1; color: white; border: none; padding: 5px 8px; border-radius: 5px; text-decoration: none; font-size: 0.8rem;">{{ $index + 1 }}</a>
                                    @endforeach
                                    @if(count($demande->photos_marchandise) > 3)
                                    <span style="background: #e2e8f0; color: #4a5568; padding: 5px 8px; border-radius: 5px; font-size: 0.8rem;">+{{ count($demande->photos_marchandise) - 3 }}</span>
                                    @endif
                                </div>
                                @else
                                <span style="color: #a0aec0; font-style: italic;">Aucune photo</span>
                                @endif
                            </td>

                            <!-- Statut -->
                            <td style="padding: 15px;">
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
                                    'recherche_en_cours' => 'Recherche',
                                    'devis_envoye' => 'Devis Envoyé',
                                    'attente_confirmation' => 'Attente Confirm.',
                                    'commande_confirmee' => 'Confirmée',
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
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; {{ $statusStyles[$demande->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                                    {{ $statusLabels[$demande->status] ?? 'Inconnu' }}
                                </span>
                                @if($demande->date_traitement)
                                <div style="font-size: 0.8rem; color: #718096; margin-top: 5px;">Traité le: {{ \Carbon\Carbon::parse($demande->date_traitement)->format('d/m/Y') }}</div>
                                @endif
                            </td>

                            <!-- Suivi -->
                            <td style="padding: 15px;">
                                @if($demande->numero_suivi)
                                <div style="font-size: 0.9rem; color: #2d3748; margin-bottom: 3px; font-weight: 600;">{{ $demande->numero_suivi }}</div>
                                @endif
                                @if($demande->date_expedition)
                                <div style="font-size: 0.8rem; color: #718096;">Exp: {{ \Carbon\Carbon::parse($demande->date_expedition)->format('d/m/Y') }}</div>
                                @endif
                                @if($demande->date_arrivee_prevue)
                                <div style="font-size: 0.8rem; color: #718096;">Prev: {{ \Carbon\Carbon::parse($demande->date_arrivee_prevue)->format('d/m/Y') }}</div>
                                @endif
                                @if($demande->frais_douane_reels || $demande->commission_finale)
                                <div style="font-size: 0.8rem; color: #f56565; margin-top: 3px;">
                                    Frais: {{ number_format(($demande->frais_douane_reels ?? 0) + ($demande->commission_finale ?? 0), 0, ',', ' ') }} F
                                </div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if($demande->status == 'en_attente')
                                    <a href="{{ route('traiter', $demande->id) }}"
                                        style="background: #48bb78; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Traiter
                                    </a>
                                    @endif

                                    @if(in_array($demande->status, ['recherche_en_cours', 'devis_envoye']))
                                    <a href="{{ route('devis', $demande->id) }}"
                                        style="background: #4299e1; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Devis
                                    </a>
                                    @endif

                                    @if(in_array($demande->status, ['paiement_recu', 'achat_en_cours']))
                                    <a href="{{ route('achat', $demande->id) }}"
                                        style="background: #9f7aea; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Achat
                                    </a>
                                    @endif

                                    @if(in_array($demande->status, ['expedition', 'en_transit', 'arrivee']))
                                    <a href="{{ route('suivi', $demande->id) }}"
                                        style="background: #f59e0b; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Suivi
                                    </a>
                                    @endif

                                    @if(in_array($demande->status, ['arrivee', 'dedouanement', 'pret_livraison']))
                                    <a href="{{ route('douane', $demande->id) }}"
                                        style="background: #10b981; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Douane
                                    </a>
                                    @endif

                                    <a href="{{ route('details', $demande->id) }}"
                                        style="background: #ed8936; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Détails
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #718096;">
                                <div style="font-size: 3rem; margin-bottom: 15px;">🚢</div>
                                <h3 style="margin: 0; color: #2d3748;">Aucune demande trouvée</h3>
                                <p style="margin: 10px 0 0 0;">Aucune demande d'import/export ne correspond aux critères de recherche.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($demandes) && $demandes->hasPages())
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #f7fafc;">
                {{ $demandes->links() }}
            </div>
            @endif
        </div>
    </div>
@endif

</section>
@endsection