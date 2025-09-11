@extends('layouts.home')
@section('content')
{{-- Vue de gestion des crédits pour gestionnaire_credit --}}
<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">

{{-- Modals --}}
{{-- Modal pour afficher les documents --}}
<div id="documentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="position: relative; max-width: 90%; max-height: 90%; background: white; border-radius: 15px; padding: 20px;">
        <button onclick="closeDocumentModal()" style="position: absolute; top: 10px; right: 15px; background: #f56565; color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; font-weight: bold;">×</button>
        <h3 id="documentTitle" style="margin: 0 0 15px 0; color: #2d3748; text-align: center;"></h3>
        <img id="documentImage" style="max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 10px;">
        <div style="text-align: center; margin-top: 15px;">
            <button onclick="downloadDocument()" style="background: #4299e1; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                Télécharger
            </button>
        </div>
    </div>
</div>

{{-- Modal pour traitement de crédit --}}
<div id="traitementModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1001; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 15px; padding: 30px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <h3 style="margin: 0 0 20px 0; color: #2d3748; text-align: center; font-size: 1.3rem;">
            Traitement de la Demande de Crédit
        </h3>

        <form id="traitementForm" style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Décision :
                </label>
                <select id="decisionSelect" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" onchange="toggleDecisionFields()">
                    <option value="">Sélectionner une décision...</option>
                    <option value="approuve">Approuver</option>
                    <option value="rejete">Rejeter</option>
                    <option value="en_etude">Mettre en étude</option>
                </select>
            </div>

            <div id="motifRejetDiv" style="display: none;">
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Motif de rejet :
                </label>
                <textarea id="motifRejet" placeholder="Expliquez les raisons du rejet..."
                    style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
            </div>

            <div id="observationsDiv">
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Observations :
                </label>
                <textarea id="observations" placeholder="Commentaires ou observations..."
                    style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
                <button type="button" onclick="closeTraitementModal()"
                    style="background: #a0aec0; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Annuler
                </button>
                <button type="button" onclick="confirmerTraitement()"
                    style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal pour remboursement --}}
<div id="remboursementModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1001; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <h3 style="margin: 0 0 20px 0; color: #2d3748; text-align: center; font-size: 1.3rem;">
            Enregistrer un Remboursement
        </h3>

        <form id="remboursementForm" style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Montant remboursé :
                </label>
                <input type="number" id="montantRemboursement" placeholder="Montant en FCFA" step="0.01"
                    style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Type de remboursement :
                </label>
                <select id="typeRemboursement" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <option value="partiel">Remboursement partiel</option>
                    <option value="total">Remboursement total</option>
                    <option value="echeance">Échéance mensuelle</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                    Notes :
                </label>
                <textarea id="notesRemboursement" placeholder="Notes sur le remboursement..."
                    style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
                <button type="button" onclick="closeRemboursementModal()"
                    style="background: #a0aec0; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Annuler
                </button>
                <button type="button" onclick="confirmerRemboursement()"
                    style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal détails crédit --}}
<div id="detailsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1001; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 15px; padding: 30px; max-width: 800px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <h3 style="margin: 0 0 20px 0; color: #2d3748; text-align: center; font-size: 1.3rem;">
            Détails du Crédit
        </h3>
        <div id="detailsContent" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;"></div>
        <div style="text-align: center; margin-top: 20px;">
            <button onclick="closeDetailsModal()" style="background: #a0aec0; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                Fermer
            </button>
        </div>
    </div>
</div>

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
                    <button onclick="exportCredits()" style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        Exporter
                    </button>
                    <button onclick="refreshData()" style="background: #4299e1; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        Actualiser
                    </button>
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
                    <a href="#" style="background: #a0aec0; color: white; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600;">
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
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $credit->compte->nom ?? 'N/A' }} {{ $credit->compte->prenom ?? '' }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">CNI: {{ $credit->compte->cni ?? 'N/A' }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $credit->compte->telephone ?? 'N/A' }}</div>
                            </td>

                            <!-- Montant -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748; font-size: 1.1rem;">{{ number_format($credit->montant, 0, ',', ' ') }} FCFA</div>
                                <div style="font-size: 0.9rem; color: #718096;">Total: {{ number_format($credit->montant_total_rembourser, 0, ',', ' ') }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">Mensuel: {{ number_format($credit->montant_mensuel, 0, ',', ' ') }}</div>
                            </td>

                            <!-- Durée/Taux -->
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: #2d3748;">{{ $credit->duree }} mois</div>
                                <div style="font-weight: 600; color: #2d3748;">{{ $credit->taux_interet }}%</div>
                                @if($credit->date_echeance)
                                <div style="font-size: 0.9rem; color: #718096;">Échéance: {{ \Carbon\Carbon::parse($credit->date_echeance)->format('d/m/Y') }}</div>
                                @endif
                            </td>

                            <!-- Objet -->
                            <td style="padding: 15px;">
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
                            <td style="padding: 15px;">
                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                    @if($credit->demande_manuscrite)
                                    <button onclick="showDocument('{{ asset('storage/' . $credit->demande_manuscrite) }}', 'Demande Manuscrite')" 
                                        style="background: #4299e1; color: white; border: none; padding: 5px 8px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">DOC</button>
                                    @endif
                                    @if($credit->photocopie_cni)
                                    <button onclick="showDocument('{{ asset('storage/' . $credit->photocopie_cni) }}', 'CNI')" 
                                        style="background: #48bb78; color: white; border: none; padding: 5px 8px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">CNI</button>
                                    @endif
                                    @if($credit->plan_localisation)
                                    <button onclick="showDocument('{{ asset('storage/' . $credit->plan_localisation) }}', 'Plan')" 
                                        style="background: #ed8936; color: white; border: none; padding: 5px 8px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">PLAN</button>
                                    @endif
                                    @if($credit->justificatifs_financiers)
                                    <button onclick="showDocument('{{ asset('storage/' . $credit->justificatifs_financiers) }}', 'Justificatifs')" 
                                        style="background: #9f7aea; color: white; border: none; padding: 5px 8px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">FIN</button>
                                    @endif
                                </div>
                            </td>

                            <!-- Statut -->
                            <td style="padding: 15px;">
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
                            <td style="padding: 15px;">
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
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if($credit->status == 'en_attente')
                                    <button onclick="traiterCredit({{ $credit->id }})"
                                        style="background: #48bb78; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        Traiter
                                    </button>
                                    @endif

                                    @if(in_array($credit->status, ['approuve', 'debourse']))
                                    <button onclick="deboursCredit({{ $credit->id }})"
                                        style="background: #4299e1; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        Débourser
                                    </button>
                                    @endif

                                    @if(in_array($credit->status, ['debourse', 'en_remboursement', 'en_retard']))
                                    <button onclick="remboursCredit({{ $credit->id }})"
                                        style="background: #9f7aea; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        Rembours.
                                    </button>
                                    @endif

                                    <button onclick="voirDetailsCredit({{ $credit->id }})"
                                        style="background: #ed8936; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                        Détails
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #718096;">
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

<script>
    let currentDocumentUrl = '';
    let creditToProcess = null;
    let creditToRemboursement = null;

    // Fonctions pour les modals
    function showDocument(documentUrl, title) {
        document.getElementById('documentImage').src = documentUrl;
        document.getElementById('documentTitle').textContent = title;
        document.getElementById('documentModal').style.display = 'flex';
        currentDocumentUrl = documentUrl;
    }

    function closeDocumentModal() {
        document.getElementById('documentModal').style.display = 'none';
    }

    function downloadDocument() {
        const link = document.createElement('a');
        link.href = currentDocumentUrl;
        link.download = document.getElementById('documentTitle').textContent + '.pdf';
        link.click();
    }

    function closeTraitementModal() {
        document.getElementById('traitementModal').style.display = 'none';
        document.getElementById('decisionSelect').value = '';
        document.getElementById('motifRejet').value = '';
        document.getElementById('observations').value = '';
        document.getElementById('motifRejetDiv').style.display = 'none';
        creditToProcess = null;
    }

    function closeRemboursementModal() {
        document.getElementById('remboursementModal').style.display = 'none';
        document.getElementById('montantRemboursement').value = '';
        document.getElementById('typeRemboursement').value = 'partiel';
        document.getElementById('notesRemboursement').value = '';
        creditToRemboursement = null;
    }

    function closeDetailsModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }

    function toggleDecisionFields() {
        const select = document.getElementById('decisionSelect');
        const motifDiv = document.getElementById('motifRejetDiv');
        
        if (select.value === 'rejete') {
            motifDiv.style.display = 'block';
        } else {
            motifDiv.style.display = 'none';
        }
    }

    // Fonctions principales
    function traiterCredit(id) {
        creditToProcess = id;
        document.getElementById('traitementModal').style.display = 'flex';
    }

    function confirmerTraitement() {
        const decision = document.getElementById('decisionSelect').value;
        const motifRejet = document.getElementById('motifRejet').value;
        const observations = document.getElementById('observations').value;

        if (!decision) {
            alert('Veuillez sélectionner une décision');
            return;
        }

        if (decision === 'rejete' && !motifRejet.trim()) {
            alert('Veuillez saisir le motif de rejet');
            return;
        }

        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = 'Traitement...';
        button.disabled = true;

        fetch(`/gestionnaire/credits/${creditToProcess}/traiter`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                decision: decision,
                motif_rejet: motifRejet,
                observations: observations
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeTraitementModal();
                location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Erreur lors du traitement'));
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur de connexion');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }

    function deboursCredit(id) {
        if (confirm('Confirmer le débours de ce crédit ?')) {
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = 'Débours...';
            button.disabled = true;

            fetch(`/gestionnaire/credits/${id}/debourser`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Erreur: ' + (data.message || 'Erreur lors du débours'));
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur de connexion');
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    }

    function remboursCredit(id) {
        creditToRemboursement = id;
        document.getElementById('remboursementModal').style.display = 'flex';
    }

    function confirmerRemboursement() {
        const montant = document.getElementById('montantRemboursement').value;
        const type = document.getElementById('typeRemboursement').value;
        const notes = document.getElementById('notesRemboursement').value;

        if (!montant || montant <= 0) {
            alert('Veuillez saisir un montant valide');
            return;
        }

        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = 'Enregistrement...';
        button.disabled = true;

        fetch(`/gestionnaire/credits/${creditToRemboursement}/rembourser`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                montant: parseFloat(montant),
                type: type,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeRemboursementModal();
                location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Erreur lors de l\'enregistrement'));
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur de connexion');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }

    function voirDetailsCredit(id) {
        fetch(`/gestionnaire/credits/${id}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const credit = data.credit;
                const detailsContent = document.getElementById('detailsContent');
                
                detailsContent.innerHTML = `
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #2d3748;">Informations Client</h4>
                        <p><strong>Nom:</strong> ${credit.compte?.nom || 'N/A'} ${credit.compte?.prenom || ''}</p>
                        <p><strong>CNI:</strong> ${credit.compte?.cni || 'N/A'}</p>
                        <p><strong>Téléphone:</strong> ${credit.compte?.telephone || 'N/A'}</p>
                        <p><strong>Statut professionnel:</strong> ${credit.statut_professionnel || 'N/A'}</p>
                        <p><strong>Situation familiale:</strong> ${credit.situation_familiale || 'N/A'}</p>
                        <p><strong>Revenus mensuels:</strong> ${credit.revenus_mensuels ? Number(credit.revenus_mensuels).toLocaleString() + ' FCFA' : 'N/A'}</p>
                        <p><strong>Personnes à charge:</strong> ${credit.personnes_charge || 0}</p>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #2d3748;">Détails du Crédit</h4>
                        <p><strong>Montant demandé:</strong> ${Number(credit.montant).toLocaleString()} FCFA</p>
                        <p><strong>Durée:</strong> ${credit.duree} mois</p>
                        <p><strong>Taux d'intérêt:</strong> ${credit.taux_interet}%</p>
                        <p><strong>Montant total à rembourser:</strong> ${Number(credit.montant_total_rembourser).toLocaleString()} FCFA</p>
                        <p><strong>Montant mensuel:</strong> ${Number(credit.montant_mensuel).toLocaleString()} FCFA</p>
                        <p><strong>Épargne requise:</strong> ${Number(credit.montant_epargne_requis).toLocaleString()} FCFA</p>
                        <p><strong>Objet:</strong> ${credit.objet_credit || 'N/A'}</p>
                        <p><strong>Garanties:</strong> ${credit.garanties || 'N/A'}</p>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <h4 style="margin: 20px 0 10px 0; color: #2d3748;">Avalistes</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <h5 style="margin: 0 0 5px 0; color: #4a5568;">Avaliste 1</h5>
                                <p><strong>Nom:</strong> ${credit.avaliste1_nom}</p>
                                <p><strong>Téléphone:</strong> ${credit.avaliste1_telephone}</p>
                                <p><strong>CNI:</strong> ${credit.avaliste1_cni}</p>
                            </div>
                            <div>
                                <h5 style="margin: 0 0 5px 0; color: #4a5568;">Avaliste 2</h5>
                                <p><strong>Nom:</strong> ${credit.avaliste2_nom}</p>
                                <p><strong>Téléphone:</strong> ${credit.avaliste2_telephone}</p>
                                <p><strong>CNI:</strong> ${credit.avaliste2_cni}</p>
                            </div>
                        </div>
                    </div>
                    ${credit.observations ? `
                    <div style="grid-column: 1 / -1;">
                        <h4 style="margin: 20px 0 10px 0; color: #2d3748;">Observations</h4>
                        <p style="background: #f7fafc; padding: 15px; border-radius: 8px;">${credit.observations}</p>
                    </div>
                    ` : ''}
                `;
                
                document.getElementById('detailsModal').style.display = 'flex';
            } else {
                alert('Erreur lors du chargement des détails');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur de connexion');
        });
    }

    function exportCredits() {
        window.location.href = '/gestionnaire/credits/export';
    }

    function refreshData() {
        location.reload();
    }

    // Fermer les modals en cliquant à l'extérieur
    document.getElementById('documentModal').addEventListener('click', function(e) {
        if (e.target === this) closeDocumentModal();
    });

    document.getElementById('traitementModal').addEventListener('click', function(e) {
        if (e.target === this) closeTraitementModal();
    });

    document.getElementById('remboursementModal').addEventListener('click', function(e) {
        if (e.target === this) closeRemboursementModal();
    });

    document.getElementById('detailsModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailsModal();
    });

    // Fermer les modals avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDocumentModal();
            closeTraitementModal();
            closeRemboursementModal();
            closeDetailsModal();
        }
    });
</script>

</section>
@endsection
