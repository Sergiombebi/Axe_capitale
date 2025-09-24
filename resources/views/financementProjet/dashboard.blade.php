@extends('layouts.home')
@section('content')
{{-- Vue de gestion du financement de projet pour gestionnaire_financement --}}
<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">

@if(auth()->user()->role !== 'gest-financement')
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
                    <h1 style="color: #2d3748; margin: 0; font-size: 2rem; font-weight: 700;">Dashboard Gestionnaire Financement</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Gestion des demandes de financement de projet</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="{{ route('export') }}" style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
                        Exporter Rapport
                    </a>
                    <a href="{{ route('projet.dashboard') }}" style="background: #4299e1; color: white; border: none; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
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
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalProjets ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Projets Total</p>
                    </div>
                    <div style="font-size: 2rem;">💼</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #ed8936, #dd6b20); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $projetsEnAttenteFrais ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Frais en Attente</p>
                    </div>
                    <div style="font-size: 2rem;">💳</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $projetsEnEtude ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Étude</p>
                    </div>
                    <div style="font-size: 2rem;">📊</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $projetsApprouves ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Approuvés</p>
                    </div>
                    <div style="font-size: 2rem;">✅</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #9f7aea, #805ad5); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.3rem; font-weight: 700;">{{ number_format($montantTotalDemande ?? 0, 0, ',', ' ') }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Demandé (FCFA)</p>
                    </div>
                    <div style="font-size: 2rem;">💰</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.3rem; font-weight: 700;">{{ number_format($montantTotalFinance ?? 0, 0, ',', ' ') }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Financé (FCFA)</p>
                    </div>
                    <div style="font-size: 2rem;">🏆</div>
                </div>
            </div>
        </div>

        {{-- Filtres et Recherche --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Rechercher</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom projet, client, référence..."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; transition: all 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Statut</label>
                    <select name="status" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Tous</option>
                        <option value="frais_en_attente" {{ request('status') == 'frais_en_attente' ? 'selected' : '' }}>Frais en Attente</option>
                        <option value="en_etude" {{ request('status') == 'en_etude' ? 'selected' : '' }}>En Étude</option>
                        <option value="approuve" {{ request('status') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                        <option value="rejete" {{ request('status') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                        <option value="finance" {{ request('status') == 'finance' ? 'selected' : '' }}>Financé</option>
                        <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En Cours</option>
                        <option value="termine" {{ request('status') == 'termine' ? 'selected' : '' }}>Terminé</option>
                        <option value="suspendu" {{ request('status') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Secteur</label>
                    <select name="secteur" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Tous secteurs</option>
                        <option value="agriculture" {{ request('secteur') == 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                        <option value="commerce" {{ request('secteur') == 'commerce' ? 'selected' : '' }}>Commerce</option>
                        <option value="artisanat" {{ request('secteur') == 'artisanat' ? 'selected' : '' }}>Artisanat</option>
                        <option value="services" {{ request('secteur') == 'services' ? 'selected' : '' }}>Services</option>
                        <option value="technologie" {{ request('secteur') == 'technologie' ? 'selected' : '' }}>Technologie</option>
                        <option value="tourisme" {{ request('secteur') == 'tourisme' ? 'selected' : '' }}>Tourisme</option>
                        <option value="education" {{ request('secteur') == 'education' ? 'selected' : '' }}>Éducation</option>
                        <option value="sante" {{ request('secteur') == 'sante' ? 'selected' : '' }}>Santé</option>
                        <option value="transport" {{ request('secteur') == 'transport' ? 'selected' : '' }}>Transport</option>
                        <option value="autre" {{ request('secteur') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="background: #4299e1; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1;">
                        Filtrer
                    </button>
                    <a href="{{ route('projet.dashboard') }}" style="background: #a0aec0; color: white; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: inline-block;">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tableau des projets --}}
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="background: linear-gradient(135deg, #2d3748, #4a5568); color: white; padding: 20px;">
                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">Gestion des Projets de Financement</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f7fafc;">
                        <tr>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Client/Projet</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Secteur/Description</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Financement</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Documents</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Statut</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Dates</th>
                            <th style="padding: 15px; text-align: center; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projets ?? [] as $projet)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f7fafc'" onmouseout="this.style.backgroundColor='white'">
                            <!-- Client/Projet -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $projet->compte->nom ?? 'N/A' }} {{ $projet->compte->prenom ?? '' }}</div>
                                <div style="font-size: 1rem; color: #2d3748; font-weight: 500; margin-bottom: 3px;">{{ $projet->nom_projet }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $projet->compte->telephone ?? 'N/A' }}</div>
                            </td>

                            <!-- Secteur/Description -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #4299e1; font-size: 0.9rem; margin-bottom: 5px; text-transform: capitalize;">{{ ucfirst($projet->secteur_activite) }}</div>
                                <div style="font-size: 0.9rem; color: #2d3748; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $projet->description_projet }}">
                                    {{ Str::limit($projet->description_projet, 80) }}
                                </div>
                                @if($projet->employes_prevus)
                                <div style="font-size: 0.8rem; color: #718096; margin-top: 5px;">Emplois prévus: {{ $projet->employes_prevus }}</div>
                                @endif
                            </td>

                            <!-- Financement -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 3px;">Total: {{ number_format($projet->montant_total_projet, 0, ',', ' ') }} FCFA</div>
                                <div style="font-size: 0.9rem; color: #4299e1; font-weight: 600; margin-bottom: 3px;">Demandé: {{ number_format($projet->montant_financement_demande, 0, ',', ' ') }} FCFA</div>
                                <div style="font-size: 0.9rem; color: #48bb78; margin-bottom: 3px;">Apport: {{ number_format($projet->apport_personnel, 0, ',', ' ') }} FCFA</div>
                                @if($projet->montant_finance)
                                <div style="font-size: 0.9rem; color: #10b981; font-weight: 600;">Financé: {{ number_format($projet->montant_finance, 0, ',', ' ') }} FCFA</div>
                                @endif
                                <div style="font-size: 0.8rem; color: #718096;">Durée: {{ $projet->duree_remboursement }} mois</div>
                            </td>

                            <!-- Documents -->
                            <td style="padding: 15px;">
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    @if($projet->business_plan)
                                    <a href="{{ asset('storage/' . $projet->business_plan) }}" target="_blank"
                                        style="background: #4299e1; color: white; padding: 3px 8px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; text-align: center;">Business Plan</a>
                                    @endif
                                    @if($projet->photocopie_cni)
                                    <a href="{{ asset('storage/' . $projet->photocopie_cni) }}" target="_blank"
                                        style="background: #48bb78; color: white; padding: 3px 8px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; text-align: center;">CNI</a>
                                    @endif
                                    @if($projet->attestation_niu)
                                    <a href="{{ asset('storage/' . $projet->attestation_niu) }}" target="_blank"
                                        style="background: #9f7aea; color: white; padding: 3px 8px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; text-align: center;">NIU</a>
                                    @endif
                                </div>
                            </td>

                            <!-- Statut -->
                            <td style="padding: 15px;">
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
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; {{ $statusStyles[$projet->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                                    {{ $statusLabels[$projet->status] ?? 'Inconnu' }}
                                </span>
                                @if($projet->frais_etude_paye)
                                <div style="font-size: 0.8rem; color: #10b981; margin-top: 5px; font-weight: 600;">✓ Frais payés</div>
                                @else
                                <div style="font-size: 0.8rem; color: #f56565; margin-top: 5px;">⏳ Frais en attente</div>
                                @endif
                            </td>

                            <!-- Dates -->
                            <td style="padding: 15px;">
                                <div style="font-size: 0.8rem; color: #718096; margin-bottom: 3px;">Créé: {{ $projet->created_at->format('d/m/Y') }}</div>
                                @if($projet->date_paiement_frais)
                                <div style="font-size: 0.8rem; color: #10b981; margin-bottom: 3px;">Frais: {{ \Carbon\Carbon::parse($projet->date_paiement_frais)->format('d/m/Y') }}</div>
                                @endif
                                @if($projet->date_traitement)
                                <div style="font-size: 0.8rem; color: #4299e1; margin-bottom: 3px;">Traité: {{ \Carbon\Carbon::parse($projet->date_traitement)->format('d/m/Y') }}</div>
                                @endif
                                @if($projet->date_approbation)
                                <div style="font-size: 0.8rem; color: #48bb78;">Approuvé: {{ \Carbon\Carbon::parse($projet->date_approbation)->format('d/m/Y') }}</div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if($projet->status == 'frais_en_attente' && $projet->frais_etude_paye)
                                    <a href="{{ route('etudier', $projet->id) }}"
                                        style="background: #4299e1; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Étudier
                                    </a>
                                    @endif

                                    @if($projet->status == 'en_etude')
                                    <a href="{{ route('evaluer', $projet->id) }}"
                                        style="background: #9f7aea; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Évaluer
                                    </a>
                                    @endif

                                    @if($projet->status == 'approuve')
                                    <a href="{{ route('financer', $projet->id) }}"
                                        style="background: #48bb78; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Financer
                                    </a>
                                    @endif

                                    @if(in_array($projet->status, ['finance', 'en_cours']))
                                    <a href="{{ route('suivie', $projet->id) }}"
                                        style="background: #f59e0b; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Suivi
                                    </a>
                                    @endif

                                    @if($projet->status == 'frais_en_attente')
                                    <a href="{{ route('confirmer_paiement', $projet->id) }}"
                                        style="background: #10b981; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Confirmer Paiement
                                    </a>
                                    @endif

                                    <a href="{{ route('detailes', $projet->id) }}"
                                        style="background: #ed8936; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Détails
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #718096;">
                                <div style="font-size: 3rem; margin-bottom: 15px;">💼</div>
                                <h3 style="margin: 0; color: #2d3748;">Aucun projet trouvé</h3>
                                <p style="margin: 10px 0 0 0;">Aucun projet de financement ne correspond aux critères de recherche.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($projets) && $projets->hasPages())
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #f7fafc;">
                {{ $projets->links() }}
            </div>
            @endif
        </div>

        

        
    </div>
@endif

</section>
@endsection
{{-- Fin du fichier dasboard.blade.php --}}