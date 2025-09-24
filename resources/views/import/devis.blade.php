{{-- resources/views/gestionnaire/import-export/devis.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Création du Devis</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $demande->numero_reference }} - {{ $demande->nom_marchandise }}</p>
                </div>
                <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Résumé de la demande client --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Résumé de la Demande Client</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Quantité Demandée</div>
                    <div style="color: #2d3748; font-weight: 600; font-size: 1.1rem;">{{ $demande->quantite_souhaitee }} {{ $demande->unite_mesure }}</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Budget Client</div>
                    <div style="color: #2d3748; font-weight: 600; font-size: 1.1rem;">
                        {{ $demande->budget_approximatif ? number_format($demande->budget_approximatif, 0, ',', ' ') . ' FCFA' : 'Non spécifié' }}
                    </div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Mode Préféré</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">
                        {{ $demande->mode_expedition ?? 'Pas de préférence' }}
                    </div>
                </div>
            </div>

            <div style="background: #f0f9ff; padding: 15px; border-radius: 8px;">
                <h4 style="margin: 0 0 10px 0; color: #1e40af;">Description Produit</h4>
                <p style="margin: 0; color: #1e3a8a;">{{ $demande->description_marchandise }}</p>
            </div>
        </div>

        {{-- Formulaire de devis --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Informations du Devis</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('devis.post', $demande->id) }}" id="devisForm">
                @csrf
                
                {{-- Informations produit --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #2d3748; margin: 0 0 20px 0;">Informations Produit</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Prix unitaire (FCFA) *
                            </label>
                            <input type="number" name="prix_unitaire_propose" value="{{ old('prix_unitaire_propose', $demande->prix_unitaire_propose) }}" required min="1" step="1"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" oninput="calculerTotal()">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Quantité finale *
                            </label>
                            <input type="number" name="quantite_finale" value="{{ old('quantite_finale', $demande->quantite_finale ?? $demande->quantite_souhaitee) }}" required min="1"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" oninput="calculerTotal()">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Poids estimé (kg) *
                            </label>
                            <input type="number" name="poids_estime_kg" value="{{ old('poids_estime_kg', $demande->poids_estime_kg) }}" required min="0.1" step="0.1"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" oninput="calculerFrais()">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Mode d'expédition *
                            </label>
                            <select name="mode_expedition_final" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner le mode...</option>
                                <option value="bateau" {{ old('mode_expedition_final', $demande->mode_expedition_final) == 'bateau' ? 'selected' : '' }}>
                                    Par bateau (2-3 mois, économique)
                                </option>
                                <option value="avion" {{ old('mode_expedition_final', $demande->mode_expedition_final) == 'avion' ? 'selected' : '' }}>
                                    Par avion (1-1.5 mois, rapide)
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Calculs automatiques --}}
                <div style="background: #e0f2fe; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #0c4a6e; margin: 0 0 20px 0;">Calculs Automatiques</h4>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Prix Total Marchandise</div>
                            <div id="prixTotal" style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">0 FCFA</div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Frais Douane (10,000/kg)</div>
                            <div id="fraisDouane" style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">0 FCFA</div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Commission AXE (1,000/kg)</div>
                            <div id="commission" style="color: #0369a1; font-weight: 700; font-size: 1.2rem;">0 FCFA</div>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 8px; text-align: center; border: 2px solid #0369a1;">
                            <div style="color: #0c4a6e; font-size: 0.9rem; margin-bottom: 5px;">Coût Total Client</div>
                            <div id="coutTotal" style="color: #0369a1; font-weight: 700; font-size: 1.3rem;">0 FCFA</div>
                        </div>
                    </div>
                </div>

                {{-- Détails du devis --}}
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Détails du devis (visible par le client)
                    </label>
                    <textarea name="details_devis" placeholder="Description détaillée du produit trouvé, spécifications, délais, conditions particulières..." 
                        style="width: 100%; min-height: 120px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('details_devis', $demande->details_devis) }}</textarea>
                </div>

                {{-- Récapitulatif pour le client --}}
                <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 2px solid #16a34a;">
                    <h4 style="color: #15803d; margin: 0 0 15px 0;">Récapitulatif pour le Client</h4>
                    <div style="color: #14532d; line-height: 1.8;">
                        <p style="margin: 0 0 10px 0;"><strong>Produit:</strong> {{ $demande->nom_marchandise }}</p>
                        <p style="margin: 0 0 10px 0;"><strong>Quantité:</strong> <span id="quantiteAffichage">{{ $demande->quantite_souhaitee }}</span> {{ $demande->unite_mesure }}</p>
                        <p style="margin: 0 0 10px 0;"><strong>Prix unitaire:</strong> <span id="prixUnitaireAffichage">-</span> FCFA</p>
                        <p style="margin: 0 0 10px 0;"><strong>Poids estimé:</strong> <span id="poidsAffichage">-</span> kg</p>
                        <p style="margin: 0 0 15px 0;"><strong>Mode d'expédition:</strong> <span id="expeditionAffichage">-</span></p>
                        
                        <div style="background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #16a34a;">
                            <p style="margin: 0 0 5px 0;"><strong>À payer maintenant:</strong> <span id="aPayer" style="font-size: 1.1rem; color: #15803d;">0 FCFA</span></p>
                            <p style="margin: 0; color: #16a34a; font-size: 0.9rem;">
                                À payer à l'arrivée: <span id="aPayerArrivee">0 FCFA</span> (douane + commission)
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Boutons --}}
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="#" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #4299e1; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Envoyer le Devis au Client
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculerTotal() {
            const prixUnitaire = parseFloat(document.querySelector('input[name="prix_unitaire_propose"]').value) || 0;
            const quantite = parseFloat(document.querySelector('input[name="quantite_finale"]').value) || 0;
            const total = prixUnitaire * quantite;
            
            document.getElementById('prixTotal').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
            document.getElementById('prixUnitaireAffichage').textContent = new Intl.NumberFormat('fr-FR').format(prixUnitaire);
            document.getElementById('quantiteAffichage').textContent = quantite;
            document.getElementById('aPayer').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
            
            calculerCoutTotal();
        }

        function calculerFrais() {
            const poids = parseFloat(document.querySelector('input[name="poids_estime_kg"]').value) || 0;
            const fraisDouane = poids * 10000;
            const commission = poids * 1000;
            
            document.getElementById('fraisDouane').textContent = new Intl.NumberFormat('fr-FR').format(fraisDouane) + ' FCFA';
            document.getElementById('commission').textContent = new Intl.NumberFormat('fr-FR').format(commission) + ' FCFA';
            document.getElementById('poidsAffichage').textContent = poids;
            document.getElementById('aPayerArrivee').textContent = new Intl.NumberFormat('fr-FR').format(fraisDouane + commission) + ' FCFA';
            
            calculerCoutTotal();
        }

        function calculerCoutTotal() {
            const prixUnitaire = parseFloat(document.querySelector('input[name="prix_unitaire_propose"]').value) || 0;
            const quantite = parseFloat(document.querySelector('input[name="quantite_finale"]').value) || 0;
            const poids = parseFloat(document.querySelector('input[name="poids_estime_kg"]').value) || 0;
            
            const prixMarchandise = prixUnitaire * quantite;
            const fraisDouane = poids * 10000;
            const commission = poids * 1000;
            const coutTotal = prixMarchandise + fraisDouane + commission;
            
            document.getElementById('coutTotal').textContent = new Intl.NumberFormat('fr-FR').format(coutTotal) + ' FCFA';
        }

        // Mise à jour de l'affichage du mode d'expédition
        document.querySelector('select[name="mode_expedition_final"]').addEventListener('change', function() {
            const modeText = this.options[this.selectedIndex].text;
            document.getElementById('expeditionAffichage').textContent = modeText.includes('bateau') ? 'Par bateau (2-3 mois)' : 
                                                                        modeText.includes('avion') ? 'Par avion (1-1.5 mois)' : '-';
        });

        // Calculs initiaux
        document.addEventListener('DOMContentLoaded', function() {
            calculerTotal();
            calculerFrais();
        });
    </script>
</section>

@endsection