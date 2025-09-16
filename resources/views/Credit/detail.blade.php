{{-- resources/views/gestionnaire/credits/details.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Détails du Crédit #{{ $credit->id }}</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $credit->compte->nom }} {{ $credit->compte->prenom }}</p>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    @if($credit->status == 'en_attente')
                    <a href="{{ route('gestionnaire.credits.traiter', $credit->id) }}" style="background: #48bb78; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Traiter
                    </a>
                    @endif
                    @if(in_array($credit->status, ['debourse', 'en_remboursement', 'en_retard']))
                    <a href="{{ route('gestionnaire.credits.rembourser', $credit->id) }}" style="background: #9f7aea; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Remboursement
                    </a>
                    @endif
                    <a href="{{ route('gestionnaire.credits.index') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        {{-- Statut du crédit --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h3 style="margin: 0; color: #2d3748;">Statut actuel</h3>
                </div>
                <div>
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
                        'en_remboursement' => 'En Remboursement',
                        'rembourse' => 'Remboursé',
                        'en_retard' => 'En Retard',
                        'contentieux' => 'Contentieux'
                    ];
                    @endphp
                    <span style="padding: 12px 24px; border-radius: 25px; font-size: 1.1rem; font-weight: 600; {{ $statusStyles[$credit->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                        {{ $statusLabels[$credit->status] ?? 'Inconnu' }}
                    </span>
                </div>
            </div>
            
            @if($credit->date_traitement)
            <p style="margin: 15px 0 0 0; color: #718096;">
                Traité le: {{ \Carbon\Carbon::parse($credit->date_traitement)->format('d/m/Y à H:i') }}
            </p>
            @endif
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            {{-- Informations client --}}
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations Client</h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <strong style="color: #4a5568;">Nom complet:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->compte->nom }} {{ $credit->compte->prenom }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">CNI:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->compte->cni ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Téléphone:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->compte->telephone ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Email:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->compte->email ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Adresse:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->compte->adresse ?? 'Non renseignée' }}</p>
                    </div>
                </div>
            </div>

            {{-- Détails du crédit --}}
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Détails du Crédit</h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <strong style="color: #4a5568;">Montant demandé:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; font-size: 1.2rem; font-weight: 600;">{{ number_format($credit->montant, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Durée:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->duree }} mois</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Taux d'intérêt:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ $credit->taux_interet }}%</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Montant total à rembourser:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; font-weight: 600;">{{ number_format($credit->montant_total_rembourser, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Montant mensuel:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748; font-weight: 600;">{{ number_format($credit->montant_mensuel, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <strong style="color: #4a5568;">Épargne requise:</strong>
                        <p style="margin: 5px 0 0 0; color: #2d3748;">{{ number_format($credit->montant_epargne_requis ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informations détaillées --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations Détaillées</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                <div>
                    <h4 style="color: #4a5568; margin: 0 0 15px 0;">Situation Professionnelle</h4>
                    <p><strong>Statut:</strong> {{ $credit->statut_professionnel ?? 'Non renseigné' }}</p>
                    <p><strong>Revenus mensuels:</strong> {{ $credit->revenus_mensuels ? number_format($credit->revenus_mensuels, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}</p>
                    <p><strong>Situation familiale:</strong> {{ $credit->situation_familiale ?? 'Non renseignée' }}</p>
                    <p><strong>Personnes à charge:</strong> {{ $credit->personnes_charge ?? 0 }}</p>
                </div>
                
                <div>
                    <h4 style="color: #4a5568; margin: 0 0 15px 0;">Objet du Crédit</h4>
                    <p style="background: #f7fafc; padding: 15px; border-radius: 8px; margin: 0;">{{ $credit->objet_credit ?? 'Non spécifié' }}</p>
                    @if($credit->garanties)
                    <h4 style="color: #4a5568; margin: 15px 0 10px 0;">Garanties</h4>
                    <p style="background: #f7fafc; padding: 15px; border-radius: 8px; margin: 0;">{{ $credit->garanties }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Avalistes --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Avalistes</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h4 style="color: #4a5568; margin: 0 0 15px 0;">Avaliste 1</h4>
                    <p><strong>Nom:</strong> {{ $credit->avaliste1_nom ?? 'Non renseigné' }}</p>
                    <p><strong>Téléphone:</strong> {{ $credit->avaliste1_telephone ?? 'Non renseigné' }}</p>
                    <p><strong>CNI:</strong> {{ $credit->avaliste1_cni ?? 'Non renseigné' }}</p>
                </div>
                
                <div>
                    <h4 style="color: #4a5568; margin: 0 0 15px 0;">Avaliste 2</h4>
                    <p><strong>Nom:</strong> {{ $credit->avaliste2_nom ?? 'Non renseigné' }}</p>
                    <p><strong>Téléphone:</strong> {{ $credit->avaliste2_telephone ?? 'Non renseigné' }}</p>
                    <p><strong>CNI:</strong> {{ $credit->avaliste2_cni ?? 'Non renseigné' }}</p>
                </div>
            </div>
        </div>

        {{-- Documents --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Documents</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                @if($credit->demande_manuscrite)
                <div style="text-align: center;">
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px; border: 2px dashed #e2e8f0;">
                        <div style="font-size: 2rem; margin-bottom: 10px;">📄</div>
                        <p style="margin: 0 0 15px 0; font-weight: 600;">Demande Manuscrite</p>
                        <a href="{{ route('gestionnaire.credits.document', [$credit->id, 'demande_manuscrite']) }}" target="_blank" style="background: #4299e1; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">Voir</a>
                    </div>
                </div>
                @endif

                @if($credit->photocopie_cni)
                <div style="text-align: center;">
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px; border: 2px dashed #e2e8f0;">
                        <div style="font-size: 2rem; margin-bottom: 10px;">🆔</div>
                        <p style="margin: 0 0 15px 0; font-weight: 600;">Photocopie CNI</p>
                        <a href="{{ route('gestionnaire.credits.document', [$credit->id, 'photocopie_cni']) }}" target="_blank" style="background: #48bb78; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">Voir</a>
                    </div>
                </div>
                @endif

                @if($credit->plan_localisation)
                <div style="text-align: center;">
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px; border: 2px dashed #e2e8f0;">
                        <div style="font-size: 2rem; margin-bottom: 10px;">🗺️</div>
                        <p style="margin: 0 0 15px 0; font-weight: 600;">Plan de Localisation</p>
                        <a href="{{ route('gestionnaire.credits.document', [$credit->id, 'plan_localisation']) }}" target="_blank" style="background: #ed8936; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">Voir</a>
                    </div>
                </div>
                @endif

                @if($credit->justificatifs_financiers)
                <div style="text-align: center;">
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px; border: 2px dashed #e2e8f0;">
                        <div style="font-size: 2rem; margin-bottom: 10px;">💼</div>
                        <p style="margin: 0 0 15px 0; font-weight: 600;">Justificatifs Financiers</p>
                        <a href="{{ route('gestionnaire.credits.document', [$credit->id, 'justificatifs_financiers']) }}" target="_blank" style="background: #9f7aea; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">Voir</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Suivi de remboursement --}}
        @if(in_array($credit->status, ['debourse', 'en_remboursement', 'rembourse', 'en_retard', 'contentieux']))
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Suivi de Remboursement</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px;">
                <div style="background: #e6fffa; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #047857;">{{ number_format($credit->montant_rembourse ?? 0, 0, ',', ' ') }}</div>
                    <div style="color: #065f46; font-weight: 600;">Montant remboursé (FCFA)</div>
                </div>
                
                <div style="background: #fef3c7; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #92400e;">{{ number_format($credit->solde_restant ?? 0, 0, ',', ' ') }}</div>
                    <div style="color: #78350f; font-weight: 600;">Solde restant (FCFA)</div>
                </div>
                
                <div style="background: #ddd6fe; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #5b21b6;">{{ $credit->echeances_payees ?? 0 }}/{{ $credit->echeances_totales ?? $credit->duree }}</div>
                    <div style="color: #4c1d95; font-weight: 600;">Échéances payées</div>
                </div>
                
                @if($credit->jours_retard > 0)
                <div style="background: #fecaca; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #991b1b;">{{ $credit->jours_retard }}</div>
                    <div style="color: #7f1d1d; font-weight: 600;">Jours de retard</div>
                </div>
                @endif
            </div>

            {{-- Historique des remboursements --}}
            @if($credit->remboursements && $credit->remboursements->count() > 0)
            <h4 style="color: #4a5568; margin: 25px 0 15px 0;">Historique des Remboursements</h4>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f7fafc;">
                        <tr>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Date</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Montant</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Type</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #2d3748; border-bottom: 2px solid #e2e8f0;">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($credit->remboursements->sortByDesc('date_remboursement') as $remboursement)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px;">{{ \Carbon\Carbon::parse($remboursement->date_remboursement)->format('d/m/Y H:i') }}</td>
                            <td style="padding: 12px; font-weight: 600; color: #48bb78;">{{ number_format($remboursement->montant, 0, ',', ' ') }} FCFA</td>
                            <td style="padding: 12px;">
                                @php
                                $typeLabels = [
                                    'partiel' => 'Partiel',
                                    'echeance' => 'Échéance',
                                    'total' => 'Total'
                                ];
                                @endphp
                                <span style="background: #e2e8f0; color: #4a5568; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                    {{ $typeLabels[$remboursement->type] ?? $remboursement->type }}
                                </span>
                            </td>
                            <td style="padding: 12px; color: #718096;">{{ $remboursement->notes ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        @endif

        {{-- Observations et motif de rejet --}}
        @if($credit->observations || $credit->motif_rejet)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Notes et Observations</h3>
            
            @if($credit->observations)
            <div style="margin-bottom: 20px;">
                <h4 style="color: #4a5568; margin: 0 0 10px 0;">Observations</h4>
                <p style="background: #f7fafc; padding: 15px; border-radius: 8px; margin: 0; line-height: 1.6;">{{ $credit->observations }}</p>
            </div>
            @endif

            @if($credit->motif_rejet)
            <div>
                <h4 style="color: #e53e3e; margin: 0 0 10px 0;">Motif de Rejet</h4>
                <p style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin: 0; line-height: 1.6;">{{ $credit->motif_rejet }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- Historique des modifications --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Historique</h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="background: #f7fafc; padding: 15px; border-left: 4px solid #4299e1; border-radius: 0 8px 8px 0;">
                    <div style="font-weight: 600; color: #2d3748;">Demande créée</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{ $credit->created_at->format('d/m/Y à H:i') }}</div>
                </div>

                @if($credit->date_traitement)
                <div style="background: #f7fafc; padding: 15px; border-left: 4px solid #48bb78; border-radius: 0 8px 8px 0;">
                    <div style="font-weight: 600; color: #2d3748;">Demande traitée</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($credit->date_traitement)->format('d/m/Y à H:i') }}</div>
                    <div style="color: #718096; font-size: 0.9rem;">Statut: {{ $statusLabels[$credit->status] ?? $credit->status }}</div>
                </div>
                @endif

                @if($credit->date_debours)
                <div style="background: #f7fafc; padding: 15px; border-left: 4px solid #9f7aea; border-radius: 0 8px 8px 0;">
                    <div style="font-weight: 600; color: #2d3748;">Crédit déboursé</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($credit->date_debours)->format('d/m/Y à H:i') }}</div>
                </div>
                @endif

                @if($credit->date_dernier_remboursement)
                <div style="background: #f7fafc; padding: 15px; border-left: 4px solid #ed8936; border-radius: 0 8px 8px 0;">
                    <div style="font-weight: 600; color: #2d3748;">Dernier remboursement</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($credit->date_dernier_remboursement)->format('d/m/Y à H:i') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection