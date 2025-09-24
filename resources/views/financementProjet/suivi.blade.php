@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1000px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Suivi du Projet Financé</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">{{ $projet->nom_projet }} - FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('projet.dashboard') }}" 
                    style="background: #a0aec0; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>

            {{-- Statut actuel --}}
            <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; border-left: 4px solid #10b981;">
                <div style="font-weight: 600; margin-bottom: 5px;">💰 Projet Financé</div>
                <div style="font-size: 0.9rem;">
                    Financement accordé le {{ $projet->date_approbation ? \Carbon\Carbon::parse($projet->date_approbation)->format('d/m/Y') : 'N/A' }}
                    • Montant: {{ number_format($projet->montant_finance, 0, ',', ' ') }} FCFA
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            {{-- Partie gauche - Informations de suivi --}}
            <div>
                {{-- Évolution financière --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Situation Financière</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 25px;">
                        <div style="background: #f0fff4; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #166534; margin-bottom: 5px;">
                                {{ number_format($projet->montant_finance, 0, ',', ' ') }}
                            </div>
                            <div style="color: #166534; font-size: 0.9rem;">Montant Financé (FCFA)</div>
                        </div>

                        <div style="background: #fef3c7; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #92400e; margin-bottom: 5px;">
                                {{ number_format($projet->montant_rembourse, 0, ',', ' ') }}
                            </div>
                            <div style="color: #92400e; font-size: 0.9rem;">Montant Remboursé (FCFA)</div>
                        </div>

                        <div style="background: #fecaca; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #991b1b; margin-bottom: 5px;">
                                {{ number_format($projet->solde_restant, 0, ',', ' ') }}
                            </div>
                            <div style="color: #991b1b; font-size: 0.9rem;">Solde Restant (FCFA)</div>
                        </div>

                        <div style="background: #e0f2fe; padding: 20px; border-radius: 8px; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #0c4a6e; margin-bottom: 5px;">
                                {{ $projet->montant_finance > 0 ? round(($projet->montant_rembourse / $projet->montant_finance) * 100, 1) : 0 }}%
                            </div>
                            <div style="color: #0c4a6e; font-size: 0.9rem;">Progression</div>
                        </div>
                    </div>

                    {{-- Barre de progression --}}
                    <div style="background: #e2e8f0; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 20px;">
                        <div style="background: linear-gradient(90deg, #10b981, #059669); height: 100%; width: {{ $projet->montant_finance > 0 ? ($projet->montant_rembourse / $projet->montant_finance) * 100 : 0 }}%; transition: width 0.5s ease;"></div>
                    </div>

                    {{-- Détails du remboursement --}}
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px;">
                        <h4 style="color: #2d3748; margin: 0 0 15px 0;">Échéancier de Remboursement</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Date de début</div>
                                <div style="color: #2d3748; font-weight: 600;">{{ $projet->date_debut_remboursement ? \Carbon\Carbon::parse($projet->date_debut_remboursement)->format('d/m/Y') : 'Non définie' }}</div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Date de fin prévue</div>
                                <div style="color: #2d3748; font-weight: 600;">{{ $projet->date_fin_remboursement ? \Carbon\Carbon::parse($projet->date_fin_remboursement)->format('d/m/Y') : 'Non définie' }}</div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Mensualité théorique</div>
                                <div style="color: #2d3748; font-weight: 600;">
                                    {{ $projet->duree_remboursement_accordee ? number_format(($projet->montant_finance * (1 + $projet->ratio_remboursement/100)) / $projet->duree_remboursement_accordee, 0, ',', ' ') : 'N/A' }} FCFA
                                </div>
                            </div>
                            <div>
                                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Durée restante</div>
                                <div style="color: #2d3748; font-weight: 600;">
                                    @if($projet->date_debut_remboursement && $projet->date_fin_remboursement)
                                        {{ max(0, \Carbon\Carbon::parse($projet->date_fin_remboursement)->diffInMonths(now(), false)) }} mois
                                    @else
                                        Non calculée
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Historique des paiements --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Historique des Transactions</h3>
                    
                    {{-- Simulation d'historique - en réalité, vous auriez une table liée --}}
                    <div style="display: grid; gap: 10px;">
                        @php
                        // Simulation d'historique de paiements
                        $paiements = collect([
                            ['date' => now()->subMonths(2), 'montant' => 50000, 'type' => 'remboursement', 'statut' => 'recu'],
                            ['date' => now()->subMonths(1), 'montant' => 50000, 'type' => 'remboursement', 'statut' => 'recu'],
                            ['date' => now()->subDays(5), 'montant' => 25000, 'type' => 'remboursement_partiel', 'statut' => 'recu'],
                        ]);
                        @endphp

                        @forelse($paiements as $paiement)
                        <div style="display: flex; justify-content: between; align-items: center; padding: 15px; background: #f7fafc; border-radius: 8px; border-left: 4px solid {{ $paiement['statut'] === 'recu' ? '#10b981' : '#f59e0b' }};">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 3px;">
                                    Remboursement {{ $paiement['type'] === 'remboursement_partiel' ? 'partiel' : 'mensuel' }}
                                </div>
                                <div style="color: #718096; font-size: 0.9rem;">{{ $paiement['date']->format('d/m/Y') }}</div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 700; color: #10b981; margin-bottom: 3px;">
                                    + {{ number_format($paiement['montant'], 0, ',', ' ') }} FCFA
                                </div>
                                <div style="background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                                    {{ $paiement['statut'] === 'recu' ? 'Reçu' : 'En attente' }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 30px; color: #718096;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">📊</div>
                            <div>Aucune transaction enregistrée</div>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Évolution du projet --}}
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Évolution du Projet</h3>
                    
                    @if($projet->historique_status && count($projet->historique_status) > 0)
                    <div style="display: grid; gap: 15px;">
                        @foreach(array_reverse(array_slice($projet->historique_status, -5)) as $historique)
                        <div style="display: flex; gap: 15px; padding: 15px; background: #f7fafc; border-radius: 8px; border-left: 4px solid #4299e1;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; font-size: 0.95rem; margin-bottom: 5px;">
                                    {{ $historique['note'] ?? 'Mise à jour effectuée' }}
                                </div>
                                <div style="color: #718096; font-size: 0.85rem;">
                                    {{ \Carbon\Carbon::parse($historique['date'])->format('d/m/Y H:i') }}
                                    @if(isset($historique['traite_par']))
                                    • Par {{ \App\Models\User::find($historique['traite_par'])->name ?? 'Gestionnaire' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align: center; padding: 20px; color: #718096;">
                        <div>Aucun historique disponible</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Partie droite - Actions et informations --}}
            <div>
                {{-- Informations du projet --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations du Projet</h3>
                    
                    <div style="text-align: center; margin-bottom: 20px;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; color: white; font-size: 1.5rem; font-weight: 700;">
                            {{ substr($projet->compte->nom, 0, 1) }}{{ substr($projet->compte->prenom, 0, 1) }}
                        </div>
                        <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">{{ $projet->compte->nom }} {{ $projet->compte->prenom }}</div>
                        <div style="color: #718096; font-size: 0.9rem;">{{ $projet->compte->telephone }}</div>
                    </div>

                    <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <div style="display: grid; gap: 8px; font-size: 0.9rem;">
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Secteur</span>
                                <span style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($projet->secteur_activite) }}</span>
                            </div>
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Durée accordée</span>
                                <span style="color: #2d3748; font-weight: 600;">{{ $projet->duree_remboursement_accordee }} mois</span>
                            </div>
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Taux d'intérêt</span>
                                <span style="color: #2d3748; font-weight: 600;">{{ $projet->ratio_remboursement }}%</span>
                            </div>
                            <div style="display: flex; justify-content: between;">
                                <span style="color: #718096;">Emplois prévus</span>
                                <span style="color: #2d3748; font-weight: 600;">{{ $projet->employes_prevus ?? 'Non spécifié' }}</span>
                            </div>
                        </div>
                    </div>

                    @if($projet->observations)
                    <div style="background: #ebf8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #4299e1;">
                        <h5 style="color: #1e40af; margin: 0 0 8px 0; font-size: 0.9rem;">Dernières observations</h5>
                        <div style="color: #1e3a8a; font-size: 0.9rem; line-height: 1.5;">{{ Str::limit($projet->observations, 150) }}</div>
                    </div>
                    @endif
                </div>

                {{-- Formulaire de mise à jour --}}
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Mise à Jour du Suivi</h3>
                    
                    <form method="POST" action="{{ route('mettre_a_jour_suivi', $projet->id) }}">
                        @csrf
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Statut du projet
                            </label>
                            <select name="nouveau_statut" 
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="finance" {{ $projet->status === 'finance' ? 'selected' : '' }}>Financé</option>
                                <option value="en_cours" {{ $projet->status === 'en_cours' ? 'selected' : '' }}>En Cours</option>
                                <option value="termine" {{ $projet->status === 'termine' ? 'selected' : '' }}>Terminé</option>
                                <option value="suspendu" {{ $projet->status === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Montant remboursé total (FCFA)
                            </label>
                            <input type="number" name="montant_rembourse" value="{{ $projet->montant_rembourse }}" 
                                min="0" max="{{ $projet->montant_finance * 1.2 }}" step="1000"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <div style="color: #718096; font-size: 0.85rem; margin-top: 6px;">
                                Saisissez le montant total déjà remboursé par le porteur du projet.
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Observations / Notes
                            </label>
                            <textarea name="observations" rows="4"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">{{ old('observations', $projet->observations) }}</textarea>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" 
                                style="background: #4f46e5; color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: background 0.3s;">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection