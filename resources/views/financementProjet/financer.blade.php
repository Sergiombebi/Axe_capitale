@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 900px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Finalisation du Financement</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">{{ $projet->nom_projet }} - FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('projet.dashboard') }}" 
                    style="background: #a0aec0; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>

            {{-- Statut d'approbation --}}
            <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; border-left: 4px solid #10b981;">
                <div style="font-weight: 600; margin-bottom: 5px;">✓ Projet Approuvé</div>
                <div style="font-size: 0.9rem;">
                    Approuvé le {{ $projet->date_approbation ? \Carbon\Carbon::parse($projet->date_approbation)->format('d/m/Y') : 'N/A' }}
                    par {{ $projet->traite_par ? \App\Models\User::find($projet->traite_par)->name ?? 'Gestionnaire' : 'Système' }}
                </div>
            </div>
        </div>

        {{-- Détails du financement approuvé --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Détails du Financement Approuvé</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px;">
                <div style="background: #f0fff4; padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: #166534; margin-bottom: 8px;">
                        {{ number_format($projet->montant_finance, 0, ',', ' ') }}
                    </div>
                    <div style="color: #166534; font-weight: 600;">Montant Financé (FCFA)</div>
                </div>
                
                <div style="background: #ebf8ff; padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: #1e40af; margin-bottom: 8px;">
                        {{ $projet->duree_remboursement_accordee }}
                    </div>
                    <div style="color: #1e40af; font-weight: 600;">Durée (mois)</div>
                </div>
                
                <div style="background: #fef3c7; padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: #92400e; margin-bottom: 8px;">
                        {{ $projet->ratio_remboursement }}%
                    </div>
                    <div style="color: #92400e; font-weight: 600;">Taux d'Intérêt</div>
                </div>
                
                <div style="background: #faf5ff; padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 1.3rem; font-weight: 700; color: #7c3aed; margin-bottom: 8px;">
                        {{ number_format(($projet->montant_finance * (1 + $projet->ratio_remboursement/100)) / $projet->duree_remboursement_accordee, 0, ',', ' ') }}
                    </div>
                    <div style="color: #7c3aed; font-weight: 600;">Mensualité Estimée (FCFA)</div>
                </div>
            </div>

            {{-- Calculs détaillés --}}
            <div style="background: #f7fafc; padding: 20px; border-radius: 8px;">
                <h4 style="color: #2d3748; margin: 0 0 15px 0;">Calculs de Remboursement</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                    <div>
                        <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Capital à rembourser</div>
                        <div style="color: #2d3748; font-weight: 600;">{{ number_format($projet->montant_finance, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div>
                        <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Intérêts totaux</div>
                        <div style="color: #2d3748; font-weight: 600;">{{ number_format($projet->montant_finance * ($projet->ratio_remboursement/100), 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div>
                        <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Montant total à rembourser</div>
                        <div style="color: #2d3748; font-weight: 600;">{{ number_format($projet->montant_finance * (1 + $projet->ratio_remboursement/100), 0, ',', ' ') }} FCFA</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informations du bénéficiaire --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Bénéficiaire du Financement</h3>
            
            <div style="display: flex; align-items: center; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 8px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; flex-shrink: 0;">
                    {{ substr($projet->compte->nom, 0, 1) }}{{ substr($projet->compte->prenom, 0, 1) }}
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 1.2rem; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        {{ $projet->compte->nom }} {{ $projet->compte->prenom }}
                    </div>
                    <div style="color: #718096; margin-bottom: 5px;">
                        <strong>Téléphone:</strong> {{ $projet->compte->telephone }}
                    </div>
                    <div style="color: #718096; margin-bottom: 5px;">
                        <strong>Email:</strong> {{ $projet->compte->email ?? 'Non renseigné' }}
                    </div>
                    <div style="color: #718096;">
                        <strong>Projet:</strong> {{ $projet->nom_projet }} ({{ ucfirst($projet->secteur_activite) }})
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire de finalisation --}}
        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Finalisation du Financement</h3>
            
            <form method="POST" action="{{ route('accorder_financement', $projet->id) }}">
                @csrf
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Date de début de remboursement *
                    </label>
                    <input type="date" name="date_debut_remboursement" 
                        value="{{ old('date_debut_remboursement', date('Y-m-d', strtotime('+1 month'))) }}" 
                        min="{{ date('Y-m-d', strtotime('+1 week')) }}" required
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <div style="color: #718096; font-size: 0.9rem; margin-top: 5px;">
                        La date ne peut pas être antérieure à {{ date('d/m/Y', strtotime('+1 week')) }}
                    </div>
                    @error('date_debut_remboursement')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Conditions de remboursement *
                    </label>
                    <textarea name="conditions_remboursement" rows="6" required placeholder="Détaillez les conditions de remboursement, modalités de paiement, pénalités de retard, etc."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;">{{ old('conditions_remboursement', 'Remboursement mensuel de ' . number_format(($projet->montant_finance * (1 + $projet->ratio_remboursement/100)) / $projet->duree_remboursement_accordee, 0, ',', ' ') . ' FCFA pendant ' . $projet->duree_remboursement_accordee . ' mois.

Modalités de paiement :
- Virement bancaire ou paiement mobile money
- Échéance le 5 de chaque mois
- Pénalité de retard : 2% du montant dû par mois de retard
- Possibilité de remboursement anticipé sans pénalité

Garanties :
- Suivi mensuel de l\'avancement du projet
- Rapport d\'activité trimestriel obligatoire') }}</textarea>
                    @error('conditions_remboursement')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Observations sur le financement (optionnel)
                    </label>
                    <textarea name="observations_financement" rows="3" placeholder="Notes complémentaires sur l'accord de financement..."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;">{{ old('observations_financement') }}</textarea>
                    @error('observations_financement')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Récapitulatif final --}}
                <div style="background: #f0fff4; padding: 20px; border-radius: 8px; border-left: 4px solid #10b981; margin-bottom: 25px;">
                    <h4 style="color: #166534; margin: 0 0 15px 0;">Récapitulatif du Financement</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; color: #166534;">
                        <div><strong>Montant accordé:</strong> {{ number_format($projet->montant_finance, 0, ',', ' ') }} FCFA</div>
                        <div><strong>Durée:</strong> {{ $projet->duree_remboursement_accordee }} mois</div>
                        <div><strong>Taux:</strong> {{ $projet->ratio_remboursement }}%</div>
                        <div><strong>Mensualité:</strong> {{ number_format(($projet->montant_finance * (1 + $projet->ratio_remboursement/100)) / $projet->duree_remboursement_accordee, 0, ',', ' ') }} FCFA</div>
                        <div><strong>Total à rembourser:</strong> {{ number_format($projet->montant_finance * (1 + $projet->ratio_remboursement/100), 0, ',', ' ') }} FCFA</div>
                        <div><strong>Date fin prévue:</strong> {{ date('d/m/Y', strtotime('+' . $projet->duree_remboursement_accordee . ' months', strtotime(old('date_debut_remboursement', '+1 month')))) }}</div>
                    </div>
                </div>

                {{-- Confirmation finale --}}
                <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <input type="checkbox" name="confirmation_financement" id="confirmation_financement" required style="margin-top: 5px;">
                        <label for="confirmation_financement" style="color: #92400e; font-size: 0.95rem; line-height: 1.5;">
                            Je confirme l'accord de financement de <strong>{{ number_format($projet->montant_finance, 0, ',', ' ') }} FCFA</strong> 
                            au bénéfice de <strong>{{ $projet->compte->nom }} {{ $projet->compte->prenom }}</strong> 
                            pour le projet "{{ $projet->nom_projet }}". Le bénéficiaire sera notifié de cet accord et les 
                            fonds seront mis à disposition selon les modalités définies.
                        </label>
                    </div>
                    @error('confirmation_financement')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 10px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Actions --}}
                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('projet.dashboard') }}" 
                        style="flex: 1; background: #a0aec0; color: white; padding: 15px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; font-size: 1rem;">
                        Annuler
                    </a>
                    <button type="submit" 
                        style="flex: 2; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 1.1rem; transition: all 0.3s;">
                        🎉 Accorder le Financement
                    </button>
                </div>
            </form>
        </div>

        {{-- Prochaines étapes --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Prochaines Étapes</h3>
            
            <div style="display: grid; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f7fafc; border-radius: 8px;">
                    <div style="width: 40px; height: 40px; background: #4299e1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                    <div>
                        <div style="font-weight: 600; color: #2d3748; margin-bottom: 3px;">Notification du client</div>
                        <div style="color: #718096; font-size: 0.9rem;">Le bénéficiaire sera automatiquement notifié de l'accord de financement</div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f7fafc; border-radius: 8px;">
                    <div style="width: 40px; height: 40px; background: #48bb78; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                    <div>
                        <div style="font-weight: 600; color: #2d3748; margin-bottom: 3px;">Mise à disposition des fonds</div>
                        <div style="color: #718096; font-size: 0.9rem;">Préparation du décaissement selon les modalités convenues</div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f7fafc; border-radius: 8px;">
                    <div style="width: 40px; height: 40px; background: #f59e0b; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                    <div>
                        <div style="font-weight: 600; color: #2d3748; margin-bottom: 3px;">Suivi du projet</div>
                        <div style="color: #718096; font-size: 0.9rem;">Mise en place du suivi régulier de l'avancement et des remboursements</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection