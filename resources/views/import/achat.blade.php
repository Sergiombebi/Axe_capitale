{{-- resources/views/gestionnaire/import-export/achat.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Gestion de l'Achat en Chine</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $demande->numero_reference }} - {{ $demande->nom_marchandise }}</p>
                </div>
                <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations de la commande --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations de la Commande</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Client</div>
                    
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Quantité</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->quantite_finale }} {{ $demande->unite_mesure }}</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Prix Total</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ number_format($demande->prix_total_marchandise, 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Mode Expédition</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ $demande->mode_expedition_final }}</div>
                </div>
            </div>

            @if($demande->details_devis)
            <div style="background: #f0f9ff; padding: 15px; border-radius: 8px;">
                <h4 style="color: #1e40af; margin: 0 0 10px 0;">Détails du produit</h4>
                <p style="color: #1e3a8a; margin: 0; line-height: 1.6;">{{ $demande->details_devis }}</p>
            </div>
            @endif
        </div>

        {{-- Formulaire d'achat --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Enregistrer l'Achat</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('achat.post', $demande->id) }}">
                @csrf
                
                {{-- Informations de commande --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #2d3748; margin: 0 0 20px 0;">Informations de Commande</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Numéro de commande (Chine) *
                            </label>
                            <input type="text" name="numero_commande_chine" value="{{ old('numero_commande_chine', $demande->numero_commande_chine) }}" required
                                placeholder="Ex: CHN-2024-001234"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Date d'achat *
                            </label>
                            <input type="date" name="date_achat_chine" value="{{ old('date_achat_chine', $demande->date_achat_chine?->format('Y-m-d')) }}" required
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Poids final (kg) *
                        </label>
                        <input type="number" name="poids_final_kg" value="{{ old('poids_final_kg', $demande->poids_final_kg) }}" required min="0.1" step="0.1"
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" oninput="calculerFrais()">
                        <small style="color: #718096;">Le poids final peut différer de l'estimation initiale</small>
                    </div>
                </div>

                {{-- Calcul des frais finaux --}}
                <div style="background: #e0f2fe; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #0c4a6e; margin: 0 0 20px 0;">Frais Finaux (Calculés Automatiquement)</h4>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Frais Douane (10,000/kg)</div>
                            <div id="fraisDouane" style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">
                                {{ $demande->poids_final_kg ? number_format($demande->poids_final_kg * 10000, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                            </div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Commission AXE (1,000/kg)</div>
                            <div id="commission" style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">
                                {{ $demande->poids_final_kg ? number_format($demande->poids_final_kg * 1000, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                            </div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center; border: 2px solid #0369a1;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Total à Percevoir</div>
                            <div id="totalFrais" style="color: #0369a1; font-weight: 700; font-size: 1.3rem;">
                                {{ $demande->poids_final_kg ? number_format($demande->poids_final_kg * 11000, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informations d'expédition --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #2d3748; margin: 0 0 20px 0;">Informations d'Expédition (Optionnel)</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Date d'expédition
                            </label>
                            <input type="date" name="date_expedition" value="{{ old('date_expedition', $demande->date_expedition?->format('Y-m-d')) }}"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Numéro de suivi
                            </label>
                            <input type="text" name="numero_suivi" value="{{ old('numero_suivi', $demande->numero_suivi) }}"
                                placeholder="Ex: CP123456789CN"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Informations de suivi
                        </label>
                        <textarea name="informations_suivi" placeholder="Détails sur l'expédition, transporteur, délai estimé..."
                            style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('informations_suivi', $demande->informations_suivi) }}</textarea>
                    </div>
                </div>

                {{-- Statut après enregistrement --}}
                <div style="background: #dcfce7; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 2px solid #16a34a;">
                    <h4 style="color: #15803d; margin: 0 0 15px 0;">Statut après Enregistrement</h4>
                    <div style="color: #14532d;">
                        <p style="margin: 0 0 10px 0;">
                            Le statut sera automatiquement mis à jour vers :
                        </p>
                        <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                            <li><strong>"Achat en cours"</strong> si aucune date d'expédition n'est saisie</li>
                            <li><strong>"Expédition"</strong> si une date d'expédition est renseignée</li>
                        </ul>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #48bb78; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Enregistrer l'Achat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculerFrais() {
            const poids = parseFloat(document.querySelector('input[name="poids_final_kg"]').value) || 0;
            const fraisDouane = poids * 10000;
            const commission = poids * 1000;
            const total = fraisDouane + commission;
            
            document.getElementById('fraisDouane').textContent = new Intl.NumberFormat('fr-FR').format(fraisDouane) + ' FCFA';
            document.getElementById('commission').textContent = new Intl.NumberFormat('fr-FR').format(commission) + ' FCFA';
            document.getElementById('totalFrais').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
        }

        // Calcul initial
        document.addEventListener('DOMContentLoaded', function() {
            calculerFrais();
        });
    </script>
</section>

@endsection