{{-- resources/views/gestionnaire/import-export/douane.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Dédouanement et Livraison</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $demande->numero_reference }} - {{ $demande->nom_marchandise }}</p>
                </div>
                <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations de livraison client --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations de Livraison Client</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Client</div>
                    
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Téléphone</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->telephone_livraison }}</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Lieu de Livraison</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($demande->lieu_livraison) }}</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Ville</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->ville_livraison }}</div>
                </div>
            </div>

            @if($demande->adresse_livraison)
            <div style="background: #f0f9ff; padding: 15px; border-radius: 8px;">
                <div style="color: #1e40af; font-size: 0.9rem; margin-bottom: 5px;">Adresse de Livraison</div>
                <div style="color: #1e3a8a; font-weight: 600;">{{ $demande->adresse_livraison }}</div>
            </div>
            @endif
        </div>

        {{-- Calcul des frais --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Frais de Dédouanement</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: #fef3c7; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #92400e; font-size: 0.9rem; margin-bottom: 5px;">Poids Final</div>
                    <div style="color: #d97706; font-weight: 700; font-size: 1.3rem;">{{ $demande->poids_final_kg }} kg</div>
                </div>
                <div style="background: #fed7d7; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #742a2a; font-size: 0.9rem; margin-bottom: 5px;">Frais Douane (10,000/kg)</div>
                    <div style="color: #dc2626; font-weight: 700; font-size: 1.3rem;">{{ number_format(($demande->frais_douane_reels ?? ($demande->poids_final_kg * 10000)), 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="background: #e9d8fd; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="color: #553c9a; font-size: 0.9rem; margin-bottom: 5px;">Commission AXE (1,000/kg)</div>
                    <div style="color: #7c3aed; font-weight: 700; font-size: 1.3rem;">{{ number_format(($demande->commission_finale ?? ($demande->poids_final_kg * 1000)), 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="background: #dcfce7; padding: 20px; border-radius: 8px; text-align: center; border: 3px solid #16a34a;">
                    <div style="color: #166534; font-size: 0.9rem; margin-bottom: 5px;">Total à Percevoir</div>
                    <div style="color: #15803d; font-weight: 700; font-size: 1.5rem;">
                        {{ number_format((($demande->frais_douane_reels ?? ($demande->poids_final_kg * 10000)) + ($demande->commission_finale ?? ($demande->poids_final_kg * 1000))), 0, ',', ' ') }} FCFA
                    </div>
                </div>
            </div>

            <div style="background: #e0f2fe; padding: 20px; border-radius: 10px;">
                <h4 style="color: #0c4a6e; margin: 0 0 10px 0;">Rappel Important</h4>
                <p style="color: #0369a1; margin: 0; line-height: 1.6;">
                    Le client a déjà payé le coût de la marchandise ({{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA). 
                    Il ne reste plus qu'à percevoir les frais de douane et notre commission à la livraison.
                </p>
            </div>
        </div>

        {{-- Formulaire de gestion --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Gestion du Dédouanement et Livraison</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('douane.post', $demande->id) }}">
                @csrf
                
                {{-- Statut des paiements --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #2d3748; margin: 0 0 20px 0;">Statut des Paiements</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div style="background: white; padding: 20px; border-radius: 8px; border: 2px solid #e2e8f0;">
                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                <input type="checkbox" name="frais_douane_payes" value="1" 
                                    {{ old('frais_douane_payes', $demande->frais_douane_payes) ? 'checked' : '' }}
                                    style="margin-right: 10px; transform: scale(1.3);">
                                <label style="font-weight: 600; color: #2d3748; font-size: 1.1rem;">
                                    Frais de douane payés
                                </label>
                            </div>
                            <div style="color: #dc2626; font-weight: 700; font-size: 1.2rem; text-align: center;">
                                {{ number_format(($demande->frais_douane_reels ?? ($demande->poids_final_kg * 10000)), 0, ',', ' ') }} FCFA
                            </div>
                            <div style="color: #718096; font-size: 0.9rem; text-align: center; margin-top: 5px;">
                                Frais reversés à l'État
                            </div>
                        </div>

                        <div style="background: white; padding: 20px; border-radius: 8px; border: 2px solid #e2e8f0;">
                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                <input type="checkbox" name="commission_payee" value="1" 
                                    {{ old('commission_payee', $demande->commission_payee) ? 'checked' : '' }}
                                    style="margin-right: 10px; transform: scale(1.3);">
                                <label style="font-weight: 600; color: #2d3748; font-size: 1.1rem;">
                                    Commission AXE CAPITAL payée
                                </label>
                            </div>
                            <div style="color: #7c3aed; font-weight: 700; font-size: 1.2rem; text-align: center;">
                                {{ number_format(($demande->commission_finale ?? ($demande->poids_final_kg * 1000)), 0, ',', ' ') }} FCFA
                            </div>
                            <div style="color: #718096; font-size: 0.9rem; text-align: center; margin-top: 5px;">
                                Notre rémunération
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Frais de livraison --}}
                @if($demande->lieu_livraison === 'domicile')
                <div style="background: #fef3c7; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #92400e; margin: 0 0 15px 0;">Frais de Livraison à Domicile</h4>
                    <div>
                        <label style="display: block; font-weight: 600; color: #78350f; margin-bottom: 8px;">
                            Montant des frais de livraison (FCFA)
                        </label>
                        <input type="number" name="frais_livraison" value="{{ old('frais_livraison', $demande->frais_livraison) }}" 
                            min="0" step="500" placeholder="Ex: 5000"
                            style="width: 100%; padding: 12px; border: 2px solid #f59e0b; border-radius: 8px; font-size: 14px;">
                        <small style="color: #78350f;">Frais de transport jusqu'au domicile du client</small>
                    </div>
                </div>
                @endif

                {{-- Informations de livraison --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #2d3748; margin: 0 0 20px 0;">Informations de Livraison</h4>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Date de livraison
                        </label>
                        <input type="date" name="date_livraison" value="{{ old('date_livraison', $demande->date_livraison?->format('Y-m-d')) }}"
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <small style="color: #718096;">Laisser vide si pas encore livré</small>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Notes de livraison
                        </label>
                        <textarea name="notes_livraison" placeholder="Détails sur la livraison, problèmes rencontrés, remarques du client..." 
                            style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('notes_livraison', $demande->notes_livraison) }}</textarea>
                    </div>
                </div>

                {{-- Statut final --}}
                <div style="background: #dcfce7; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 2px solid #16a34a;">
                    <h4 style="color: #15803d; margin: 0 0 15px 0;">Statut Final Automatique</h4>
                    <div style="color: #14532d; line-height: 1.8;">
                        <p style="margin: 0 0 10px 0;">Le statut sera automatiquement mis à jour selon les critères suivants :</p>
                        <ul style="margin: 0; padding-left: 20px;">
                            <li><strong>"Dédouanement"</strong> : Si les frais ne sont pas encore tous payés</li>
                            <li><strong>"Prêt livraison"</strong> : Si tous les frais sont payés mais pas encore livré</li>
                            <li><strong>"Livré"</strong> : Si tous les frais sont payés ET une date de livraison est saisie</li>
                        </ul>
                    </div>
                </div>

                {{-- Récapitulatif financier --}}
                <div style="background: #e0f2fe; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #0c4a6e; margin: 0 0 15px 0;">Récapitulatif Financier Total</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Marchandise (Payée)</div>
                            <div style="color: #15803d; font-weight: 700;">{{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Frais Douane</div>
                            <div style="color: #dc2626; font-weight: 700;">{{ number_format(($demande->frais_douane_reels ?? ($demande->poids_final_kg * 10000)), 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Commission AXE</div>
                            <div style="color: #7c3aed; font-weight: 700;">{{ number_format(($demande->commission_finale ?? ($demande->poids_final_kg * 1000)), 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center; border: 2px solid #0369a1;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Total Général</div>
                            <div style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">
                                {{ number_format(($demande->prix_total_marchandise + ($demande->frais_douane_reels ?? ($demande->poids_final_kg * 10000)) + ($demande->commission_finale ?? ($demande->poids_final_kg * 1000)) + ($demande->frais_livraison ?? 0)), 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #48bb78; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Enregistrer les Informations
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection