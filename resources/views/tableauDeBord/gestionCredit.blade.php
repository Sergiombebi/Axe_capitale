@extends('layouts.home')
@section('content')
{{-- Vue de gestion des crédits pour gestionnaire_credit --}}
<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">

    @if(auth()->user()->role !== 'gestionnaire_credit')
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
                    <h1 style="color: #2d3748; margin: 0; font-size: 2rem; font-weight: 700;">Dashboard Gestionnaire Crédit</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Gestion des demandes de crédit</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="{{ route('gestionnaire.credits.export') }}" style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
                        Exporter
                    </a>
                    <a href="{{ route('gestionnaire.credits.index') }}" style="background: #4299e1; color: white; border: none; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-block;">
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
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $totalCredits ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Demandes Total</p>
                    </div>
                    <div style="font-size: 2rem;">💳</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #ed8936, #dd6b20); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $creditsEnAttente ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Attente</p>
                    </div>
                    <div style="font-size: 2rem;">⏳</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $creditsApprouves ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Approuvés</p>
                    </div>
                    <div style="font-size: 2rem;">✅</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #f56565, #e53e3e); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ $creditsEnRetard ?? 0 }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Retard</p>
                    </div>
                    <div style="font-size: 2rem;">⚠️</div>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #9f7aea, #805ad5); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem; font-weight: 700;">{{ number_format($montantTotalCredits ?? 0, 0, ',', ' ') }}</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Montant Total (FCFA)</p>
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom, CNI..."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; transition: all 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Statut</label>
                    <select name="status" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                        <option value="en_etude" {{ request('status') == 'en_etude' ? 'selected' : '' }}>En Étude</option>
                        <option value="approuve" {{ request('status') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                        <option value="rejete" {{ request('status') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                        <option value="debourse" {{ request('status') == 'debourse' ? 'selected' : '' }}>Déboursé</option>
                        <option value="en_remboursement" {{ request('status') == 'en_remboursement' ? 'selected' : '' }}>En Remboursement</option>
                        <option value="rembourse" {{ request('status') == 'rembourse' ? 'selected' : '' }}>Remboursé</option>
                        <option value="en_retard" {{ request('status') == 'en_retard' ? 'selected' : '' }}>En Retard</option>
                        <option value="contentieux" {{ request('status') == 'contentieux' ? 'selected' : '' }}>Contentieux</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">Montant</label>
                    <select name="montant_range" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Tous montants</option>
                        <option value="0-100000" {{ request('montant_range') == '0-100000' ? 'selected' : '' }}>0 - 100 000 FCFA</option>
                        <option value="100000-500000" {{ request('montant_range') == '100000-500000' ? 'selected' : '' }}>100 000 - 500 000 FCFA</option>
                        <option value="500000-1000000" {{ request('montant_range') == '500000-1000000' ? 'selected' : '' }}>500 000 - 1 000 000 FCFA</option>
                        <option value="1000000+" {{ request('montant_range') == '1000000+' ? 'selected' : '' }}>+ 1 000 000 FCFA</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="background: #4299e1; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1;">
                        Filtrer
                    </button>
                    <a href="{{ route('gestionnaire.credits.index') }}" style="background: #a0aec0; color: white; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: inline-block;">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tableau des crédits --}}
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="background: linear-gradient(135deg, #2d3748, #4a5568); color: white; padding: 20px;">
                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 600;">Gestion des Demandes de Crédit</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f7fafc;">
                        <tr>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Client</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Montant</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Durée/Taux</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Objet</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Documents</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Statut</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Remboursement</th>
                            <th style="padding: 15px; text-align: center; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($credits ?? [] as $credit)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f7fafc'" onmouseout="this.style.backgroundColor='white'">
                            <!-- Client -->
                            <td data-label="Client" style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $credit->compte->nom ?? 'N/A' }} {{ $credit->compte->prenom ?? '' }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">CNI: {{ $credit->compte->cni ?? 'N/A' }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $credit->compte->telephone ?? 'N/A' }}</div>
                            </td>

                            <!-- Montant -->
                            <td data-label="Montant" style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; font-size: 1.1rem;">{{ number_format($credit->montant, 0, ',', ' ') }} FCFA</div>
                                <div style="font-size: 0.9rem; color: #718096;">Total: {{ number_format($credit->montant_total_rembourser, 0, ',', ' ') }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">Mensuel: {{ number_format($credit->montant_mensuel, 0, ',', ' ') }}</div>
                            </td>

                            <!-- Durée/Taux -->
                            <td data-label="Durée/Taux" style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748;">{{ $credit->duree }} mois</div>
                                <div style="font-weight: 600; color: #2d3748;">{{ $credit->taux_interet }}%</div>
                                @if($credit->date_echeance)
                                <div style="font-size: 0.9rem; color: #718096;">Échéance: {{ \Carbon\Carbon::parse($credit->date_echeance)->format('d/m/Y') }}</div>
                                @endif
                            </td>

                            <!-- Objet -->
                            <td data-label="Objet" style="padding: 15px;">
                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $credit->objet_credit }}">
                                    {{ $credit->objet_credit }}
                                </div>
                                <div style="font-size: 0.9rem; color: #718096; margin-top: 5px;">
                                    Avalistes:
                                    <div>1. {{ $credit->avaliste1_nom }}</div>
                                    <div>2. {{ $credit->avaliste2_nom }}</div>
                                </div>
                            </td>

                            <!-- Documents -->
                            <td data-label="Documents" style="padding: 10px;">
                                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                    @if($credit->demande_manuscrite)
                                    <a href="{{ Storage::url($credit->demande_manuscrite) }}" target="_blank">
                                        <img src="{{ Storage::url($credit->demande_manuscrite) }}" alt="Demande manuscrite" style="width:40px; height:40px; border-radius:5px; object-fit:cover;">
                                    </a>
                                    @endif

                                    @if($credit->photocopie_cni)
                                    <a href="{{ Storage::url($credit->photocopie_cni) }}" target="_blank">
                                        <img src="{{ Storage::url($credit->photocopie_cni) }}" alt="Photocopie CNI" style="width:40px; height:40px; border-radius:5px; object-fit:cover;">
                                    </a>
                                    @endif

                                    @if($credit->plan_localisation)
                                    <a href="{{ Storage::url($credit->plan_localisation) }}" target="_blank">
                                        <img src="{{ Storage::url($credit->plan_localisation) }}" alt="Plan de localisation" style="width:40px; height:40px; border-radius:5px; object-fit:cover;">
                                    </a>
                                    @endif

                                    @if($credit->justificatifs_financiers)
                                    <a href="{{ Storage::url($credit->justificatifs_financiers) }}" target="_blank">
                                        <img src="{{ Storage::url($credit->justificatifs_financiers) }}" alt="Justificatif financier" style="width:40px; height:40px; border-radius:5px; object-fit:cover;">
                                    </a>
                                    @endif
                                </div>
                            </td>


                            <!-- Statut -->
                            <td data-label="Statut" style="padding: 15px;">
                                @php
                                $statusStyles = [
                                'en_attente' => 'background: #fed7d7; color: #742a2a;',
                                'en_etude' => 'background: #feebc8; color: #744210;',
                                'approuve' => 'background: #c6f6d5; color: #22543d;',
                                'rejete' => 'background: #fed7d7; color: #742a2a;',
                                'debourse' => 'background: #bee3f8; color: #2a69ac;',
                                'en_remboursement' => 'background: #e9d8fd; color: #553c9a;',
                                'rembourse' => 'background: #c6f6d5; color: #22543d;',
                                'en_retard' => 'background: #fbb6ce; color: #97266d;',
                                'contentieux' => 'background: #fed7d7; color: #742a2a;'
                                ];
                                $statusLabels = [
                                'en_attente' => 'En Attente',
                                'en_etude' => 'En Étude',
                                'approuve' => 'Approuvé',
                                'rejete' => 'Rejeté',
                                'debourse' => 'Déboursé',
                                'en_remboursement' => 'Remboursement',
                                'rembourse' => 'Remboursé',
                                'en_retard' => 'En Retard',
                                'contentieux' => 'Contentieux'
                                ];
                                @endphp
                                <span style="padding: 8px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; {{ $statusStyles[$credit->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                                    {{ $statusLabels[$credit->status] ?? 'Inconnu' }}
                                </span>
                                @if($credit->date_traitement)
                                <div style="font-size: 0.8rem; color: #718096; margin-top: 5px;">Traité le: {{ \Carbon\Carbon::parse($credit->date_traitement)->format('d/m/Y') }}</div>
                                @endif
                            </td>

                            <!-- Remboursement -->
                            <td data-label="Remboursement" style="padding: 15px;">
                                @if(in_array($credit->status, ['debourse', 'en_remboursement', 'rembourse', 'en_retard', 'contentieux']))
                                <div style="font-size: 0.9rem; color: #2d3748; margin-bottom: 3px;">
                                    Remboursé: {{ number_format($credit->montant_rembourse, 0, ',', ' ') }} FCFA
                                </div>
                                <div style="font-size: 0.9rem; color: #718096; margin-bottom: 3px;">
                                    Restant: {{ number_format($credit->solde_restant, 0, ',', ' ') }} FCFA
                                </div>
                                <div style="font-size: 0.9rem; color: #718096;">
                                    Échéances: {{ $credit->echeances_payees }}/{{ $credit->echeances_totales }}
                                </div>
                                @if($credit->jours_retard > 0)
                                <div style="font-size: 0.9rem; color: #f56565; font-weight: 600;">
                                    Retard: {{ $credit->jours_retard }} jours
                                </div>
                                @endif
                                @if($credit->penalites > 0)
                                <div style="font-size: 0.9rem; color: #f56565;">
                                    Pénalités: {{ number_format($credit->penalites, 0, ',', ' ') }} FCFA
                                </div>
                                @endif
                                @else
                                <div style="color: #a0aec0; font-style: italic;">-</div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td data-label="Actions" style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if($credit->status == 'en_attente')
                                    <a href="{{ route('gestionnaire.credits.traiter', $credit->id) }}"
                                        style="background: #48bb78; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Traiter
                                    </a>
                                    @endif

                                    @if(in_array($credit->status, ['approuve', 'debourse']))
                                    <a href="{{ route('gestionnaire.credits.debourser', $credit->id) }}"
                                        onclick="return confirm('Confirmer le débours de ce crédit ?')"
                                        style="background: #4299e1; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Débourser
                                    </a>
                                    @endif

                                    @if(in_array($credit->status, ['debourse', 'en_remboursement', 'en_retard']))
                                    <a href="{{ route('gestionnaire.credits.rembourser', $credit->id) }}"
                                        style="background: #9f7aea; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Rembours.
                                    </a>
                                    @endif

                                    <a href="{{ route('gestionnaire.credits.details', $credit->id) }}"
                                        style="background: #ed8936; color: white; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        Détails
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td data-label="Client" colspan="8" style="padding: 40px; text-align: center; color: #718096;">
                                <div style="font-size: 3rem; margin-bottom: 15px;">📄</div>
                                <h3 style="margin: 0; color: #2d3748;">Aucun crédit trouvé</h3>
                                <p style="margin: 10px 0 0 0;">Aucune demande de crédit ne correspond aux critères de recherche.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($credits) && $credits->hasPages())
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #f7fafc;">
                {{ $credits->links() }}
            </div>
            @endif
        </div>
    </div>
    @endif

</section>
<style>
    /* ✅ Rendre le tableau responsive */
    @media (max-width: 768px) {

        /* Le tableau devient un bloc */
        table {
            border: 0;
        }

        thead {
            display: none;
            /* On cache les en-têtes */
        }

        tbody,
        tr,
        td {
            display: block;
            width: 100%;
        }

        tr {
            margin-bottom: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        td {
            text-align: left !important;
            padding: 10px 15px;
            position: relative;
            border: none !important;
            border-bottom: 1px solid #edf2f7 !important;
        }

        /* Labels dynamiques pour chaque cellule */
        td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #4a5568;
            display: block;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        /* Boutons d'action en bloc */
        td:last-child {
            text-align: center !important;
            border-bottom: none !important;
        }

        td:last-child div {
            flex-direction: column;
        }

        td:last-child a {
            width: 100%;
            text-align: center;
            margin-bottom: 6px;
        }
    }

    /* ✅ Ajustement du header et des filtres sur petit écran */
    @media (max-width: 768px) {
        section {
            padding: 10px !important;
        }

        h1 {
            font-size: 1.5rem !important;
        }

        form {
            grid-template-columns: 1fr !important;
        }

        form>div {
            width: 100%;
        }

        form button,
        form a {
            width: 100%;
        }

        .stats {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@endsection