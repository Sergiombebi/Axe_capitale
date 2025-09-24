{{-- resources/views/financement/projet/status.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 2rem; font-weight: 700;">Mes Projets de Financement</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1.1rem;">Suivez l'évolution de vos demandes de financement</p>
                </div>
                <a href="{{ route('financement') }}"
                    style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Nouveau Projet
                </a>
            </div>
        </div>

        @if($projets->count() > 0)
        {{-- Statistiques --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            @php
            $totalProjets = $projets->count();
            $projetsEnCours = $projets->whereIn('status', ['frais_en_attente', 'en_etude', 'approuve'])->count();
            $projetsFinances = $projets->where('status', 'finance')->count();
            $montantTotalDemande = $projets->sum('montant_financement_demande');
            @endphp

            <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 5px;">{{ $totalProjets }}</div>
                <div style="opacity: 0.9;">Projets Total</div>
            </div>

            <div style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 5px;">{{ $projetsEnCours }}</div>
                <div style="opacity: 0.9;">En Cours</div>
            </div>

            <div style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 5px;">{{ $projetsFinances }}</div>
                <div style="opacity: 0.9;">Financés</div>
            </div>

            <div style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                <div style="font-size: 1.3rem; font-weight: 700; margin-bottom: 5px;">{{ number_format($montantTotalDemande, 0, ',', ' ') }}</div>
                <div style="opacity: 0.9;">Total Demandé (FCFA)</div>
            </div>
        </div>

        {{-- Liste des projets --}}
        <div style="display: grid; gap: 25px;">
            @foreach($projets as $projet)
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s;">

                {{-- En-tête du projet --}}
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                            <h3 style="color: #2d3748; margin: 0; font-size: 1.4rem; font-weight: 700;">{{ $projet->nom_projet }}</h3>
                            <span style="background: #e2e8f0; color: #4a5568; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <p style="color: #718096; margin: 0; font-size: 0.9rem;">
                            Secteur: {{ ucfirst($projet->secteur_activite) }} •
                            Créé le {{ $projet->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <div style="text-align: right;">
                        @php
                        $statusStyles = [
                        'frais_en_attente' => 'background: #fed7d7; color: #742a2a;',
                        'en_etude' => 'background: #feebc8; color: #744210;',
                        'approuve' => 'background: #c6f6d5; color: #22543d;',
                        'rejete' => 'background: #fed7d7; color: #742a2a;',
                        'finance' => 'background: #bee3f8; color: #2a69ac;',
                        'en_cours' => 'background: #e9d8fd; color: #553c9a;',
                        'termine' => 'background: #c6f6d5; color: #22543d;',
                        'suspendu' => 'background: #fbb6ce; color: #97266d;'
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
                        <span style="padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; {{ $statusStyles[$projet->status] ?? 'background: #e2e8f0; color: #4a5568;' }}">
                            {{ $statusLabels[$projet->status] ?? 'Inconnu' }}
                        </span>
                    </div>
                </div>

                {{-- Contenu du projet --}}
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 20px;">

                    {{-- Informations principales --}}
                    <div>
                        <h4 style="color: #4a5568; margin: 0 0 15px 0; font-size: 1rem;">Description du Projet</h4>
                        <p style="color: #2d3748; margin: 0 0 15px 0; line-height: 1.6; font-size: 0.95rem;">
                            {{ Str::limit($projet->description_projet, 200) }}
                        </p>

                        @if($projet->status == 'frais_en_attente')
                        <div style="background: #fef3c7; color: #92400e; padding: 15px; border-radius: 8px; margin-top: 15px;">
                            <strong>Action Requise:</strong> Veuillez régler les frais d'étude de 5,000 FCFA pour lancer l'analyse de votre dossier.
                        </div>
                        @endif

                        @if($projet->motif_rejet)
                        <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-top: 15px;">
                            <strong>Motif de rejet:</strong> {{ $projet->motif_rejet }}
                        </div>
                        @endif

                        @if($projet->observations)
                        <div style="background: #f0f9ff; color: #1e40af; padding: 15px; border-radius: 8px; margin-top: 15px;">
                            <strong>Observations:</strong> {{ $projet->observations }}
                        </div>
                        @endif
                    </div>

                    {{-- Détails financiers --}}
                    <div style="background: #f7fafc; padding: 20px; border-radius: 10px;">
                        <h4 style="color: #4a5568; margin: 0 0 15px 0; font-size: 1rem;">Détails Financiers</h4>

                        <div style="margin-bottom: 12px;">
                            <div style="color: #718096; font-size: 0.85rem;">Montant Total Projet</div>
                            <div style="color: #2d3748; font-weight: 600; font-size: 1.1rem;">
                                {{ number_format($projet->montant_total_projet, 0, ',', ' ') }} FCFA
                            </div>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <div style="color: #718096; font-size: 0.85rem;">Financement Demandé</div>
                            <div style="color: #4299e1; font-weight: 600; font-size: 1.1rem;">
                                {{ number_format($projet->montant_financement_demande, 0, ',', ' ') }} FCFA
                            </div>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <div style="color: #718096; font-size: 0.85rem;">Apport Personnel</div>
                            <div style="color: #48bb78; font-weight: 600;">
                                {{ number_format($projet->apport_personnel, 0, ',', ' ') }} FCFA
                            </div>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <div style="color: #718096; font-size: 0.85rem;">Durée Souhaitée</div>
                            <div style="color: #2d3748; font-weight: 600;">{{ $projet->duree_remboursement }} mois</div>
                        </div>

                        @if($projet->montant_finance)
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                            <div style="color: #718096; font-size: 0.85rem;">Montant Financé</div>
                            <div style="color: #10b981; font-weight: 700; font-size: 1.2rem;">
                                {{ number_format($projet->montant_finance, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Barre de progression --}}
                @php
                $progressSteps = [
                'frais_en_attente' => 1,
                'en_etude' => 2,
                'approuve' => 3,
                'finance' => 4,
                'en_cours' => 5,
                'termine' => 6
                ];
                $currentStep = $progressSteps[$projet->status] ?? 1;
                $totalSteps = 6;
                $progressPercent = ($currentStep / $totalSteps) * 100;
                @endphp

                @if($projet->status !== 'rejete' && $projet->status !== 'suspendu')
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <h4 style="color: #4a5568; margin: 0; font-size: 0.9rem;">Progression du Projet</h4>
                        <span style="color: #718096; font-size: 0.8rem;">{{ round($progressPercent) }}% complété</span>
                    </div>

                    <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, #4299e1, #48bb78); height: 100%; width: {{ $progressPercent }}%; transition: width 0.5s ease;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-top: 15px; font-size: 0.75rem;">
                        <div style="text-align: center; color: {{ $currentStep >= 1 ? '#4299e1' : '#a0aec0' }};">
                            <div style="margin-bottom: 5px;">💳</div>
                            Frais
                        </div>
                        <div style="text-align: center; color: {{ $currentStep >= 2 ? '#4299e1' : '#a0aec0' }};">
                            <div style="margin-bottom: 5px;">🔍</div>
                            Étude
                        </div>
                        <div style="text-align: center; color: {{ $currentStep >= 3 ? '#4299e1' : '#a0aec0' }};">
                            <div style="margin-bottom: 5px;">✅</div>
                            Approbation
                        </div>
                        <div style="text-align: center; color: {{ $currentStep >= 4 ? '#4299e1' : '#a0aec0' }};">
                            <div style="margin-bottom: 5px;">💰</div>
                            Financement
                        </div>
                        <div style="text-align: center; color: {{ $currentStep >= 5 ? '#4299e1' : '#a0aec0' }};">
                            <div style="margin-bottom: 5px;">🚀</div>
                            Exécution
                        </div>
                        <div style="text-align: center; color: {{ $currentStep >= 6 ? '#48bb78' : '#a0aec0' }};">
                            <div style="margin-bottom: 5px;">🎯</div>
                            Terminé
                        </div>
                    </div>
                </div>
                @endif

                {{-- Actions et dates importantes --}}
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div style="color: #718096; font-size: 0.85rem;">
                        @if($projet->date_traitement)
                        Traité le {{ \Carbon\Carbon::parse($projet->date_traitement)->format('d/m/Y') }}
                        @elseif($projet->created_at)
                        Soumis le {{ $projet->created_at->format('d/m/Y') }}
                        @endif
                    </div>

                    <div style="display: flex; gap: 10px;">
                        @if($projet->status == 'frais_en_attente')
                        <p style="color:#4b5563; font-size:0.9rem; margin-bottom:10px;">
                            ⚠️ En cliquant sur le bouton ci-dessous, vous serez redirigé vers WhatsApp pour finaliser votre paiement.
                        </p>

                        <a href="https://wa.me/237688822232?text=Bonjour, je souhaite payer mes frais d'etude pour le projet de financement. Mon ID de projet est FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}."
                            target="_blank"
                            style="background: #f59e0b; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                            💳 Payer Frais
                        </a>
                        @endif

                        <a href="#" style="background: #4299e1; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                            Détails
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- État vide --}}
        <div style="background: white; border-radius: 15px; padding: 60px 30px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 20px;">📋</div>
            <h3 style="color: #2d3748; margin: 0 0 15px 0; font-size: 1.4rem;">Aucun Projet de Financement</h3>
            <p style="color: #718096; margin: 0 0 30px 0; line-height: 1.6;">
                Vous n'avez encore soumis aucune demande de financement de projet.<br>
                Commencez dès maintenant et concrétisez vos idées entrepreneuriales !
            </p>
            <a href="{{ route('financement') }}"
                style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block;">
                Soumettre Mon Premier Projet
            </a>
        </div>
        @endif

        {{-- Aide et support --}}
        <div style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; border-radius: 15px; padding: 25px; margin-top: 30px; text-align: center;">
            <h3 style="margin: 0 0 15px 0;">Besoin d'Assistance ?</h3>
            <p style="margin: 0 0 20px 0; opacity: 0.9;">
                Notre équipe est là pour vous accompagner dans votre projet entrepreneurial.
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="mailto:support@axecapital.com"
                    style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; backdrop-filter: blur(10px);">
                    Contacter le Support
                </a>
                <a href="#"
                    style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; backdrop-filter: blur(10px);">
                    Guide du Financement
                </a>
            </div>
        </div>
    </div>
</section>

@endsection