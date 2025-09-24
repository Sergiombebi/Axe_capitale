{{-- resources/views/gestionnaire/import-export/suivi.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Suivi de l'Expédition</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $demande->numero_reference }} - {{ $demande->nom_marchandise }}</p>
                </div>
                <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations actuelles de suivi --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations Actuelles</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">N° Commande Chine</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->numero_commande_chine ?? 'Non renseigné' }}</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">N° de Suivi</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->numero_suivi ?? 'Non renseigné' }}</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Poids Final</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $demande->poids_final_kg ?? 'Non défini' }} kg</div>
                </div>
                <div style="background: #f7fafc; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #4a5568; font-size: 0.9rem; margin-bottom: 5px;">Mode Expédition</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ $demande->mode_expedition_final }}</div>
                </div>
            </div>

            {{-- Dates importantes --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                @if($demande->date_achat_chine)
                <div style="background: #dcfce7; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #166534; font-size: 0.9rem; margin-bottom: 5px;">Date Achat</div>
                    <div style="color: #15803d; font-weight: 600;">{{ \Carbon\Carbon::parse($demande->date_achat_chine)->format('d/m/Y') }}</div>
                </div>
                @endif

                @if($demande->date_expedition)
                <div style="background: #dbeafe; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #1d4ed8; font-size: 0.9rem; margin-bottom: 5px;">Date Expédition</div>
                    <div style="color: #1e40af; font-weight: 600;">{{ \Carbon\Carbon::parse($demande->date_expedition)->format('d/m/Y') }}</div>
                </div>
                @endif

                @if($demande->date_arrivee_prevue)
                <div style="background: #fef3c7; padding: 15px; border-radius: 8px; text-align: center;">
                    <div style="color: #92400e; font-size: 0.9rem; margin-bottom: 5px;">Arrivée Prévue</div>
                    <div style="color: #d97706; font-weight: 600;">{{ \Carbon\Carbon::parse($demande->date_arrivee_prevue)->format('d/m/Y') }}</div>
                </div>
                @endif

                @if($demande->date_arrivee_effective)
                <div style="background: #dcfce7; padding: 15px; border-radius: 8px; text-align: center; border: 2px solid #16a34a;">
                    <div style="color: #166534; font-size: 0.9rem; margin-bottom: 5px;">Arrivée Effective</div>
                    <div style="color: #15803d; font-weight: 600;">{{ \Carbon\Carbon::parse($demande->date_arrivee_effective)->format('d/m/Y') }}</div>
                </div>
                @endif
            </div>

            @if($demande->informations_suivi)
            <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <h4 style="color: #1e40af; margin: 0 0 10px 0;">Dernières informations</h4>
                <p style="color: #1e3a8a; margin: 0; line-height: 1.6;">{{ $demande->informations_suivi }}</p>
            </div>
            @endif
        </div>

        {{-- Formulaire de mise à jour --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Mettre à Jour le Suivi</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('suivi.post', $demande->id) }}">
                @csrf
                
                {{-- Statut de l'expédition --}}
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Statut de l'expédition *
                    </label>
                    <select name="status" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Sélectionner le statut...</option>
                        <option value="expedition" {{ old('status', $demande->status) == 'expedition' ? 'selected' : '' }}>
                            Expédition (marchandise expédiée de Chine)
                        </option>
                        <option value="en_transit" {{ old('status', $demande->status) == 'en_transit' ? 'selected' : '' }}>
                            En Transit (en cours d'acheminement)
                        </option>
                        <option value="arrivee" {{ old('status', $demande->status) == 'arrivee' ? 'selected' : '' }}>
                            Arrivée (marchandise arrivée au port/aéroport)
                        </option>
                    </select>
                </div>

                {{-- Dates de suivi --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #2d3748; margin: 0 0 20px 0;">Dates de Suivi</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Date d'arrivée prévue
                            </label>
                            <input type="date" name="date_arrivee_prevue" 
                                value="{{ old('date_arrivee_prevue', $demande->date_arrivee_prevue?->format('Y-m-d')) }}"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Date estimée d'arrivée</small>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Date d'arrivée effective
                            </label>
                            <input type="date" name="date_arrivee_effective" 
                                value="{{ old('date_arrivee_effective', $demande->date_arrivee_effective?->format('Y-m-d')) }}"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Date réelle d'arrivée (si déjà arrivée)</small>
                        </div>
                    </div>
                </div>

                {{-- Informations détaillées --}}
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Informations de suivi détaillées
                    </label>
                    <textarea name="informations_suivi" placeholder="Position actuelle, étapes franchies, incidents éventuels, délais, transporteur..." 
                        style="width: 100%; min-height: 120px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('informations_suivi', $demande->informations_suivi) }}</textarea>
                    <small style="color: #718096;">Ces informations seront visibles par le client</small>
                </div>

                {{-- Templates de messages --}}
                <div style="background: #e0f2fe; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #0c4a6e; margin: 0 0 15px 0;">Messages Types</h4>
                    <div style="display: grid; gap: 10px;">
                        <button type="button" onclick="remplirMessage('expedition')" 
                            style="background: #0369a1; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; text-align: left;">
                            📦 Marchandise expédiée de Chine
                        </button>
                        <button type="button" onclick="remplirMessage('transit')" 
                            style="background: #0369a1; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; text-align: left;">
                            🚢 En cours d'acheminement
                        </button>
                        <button type="button" onclick="remplirMessage('douane')" 
                            style="background: #0369a1; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; text-align: left;">
                            🏛️ En cours de dédouanement
                        </button>
                        <button type="button" onclick="remplirMessage('arrivee')" 
                            style="background: #0369a1; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; text-align: left;">
                            ✅ Marchandise arrivée au port/aéroport
                        </button>
                    </div>
                </div>

                {{-- Estimation des délais --}}
                @php
                $delaiEstime = '';
                if ($demande->mode_expedition_final == 'bateau') {
                    $delaiEstime = '2 à 3 mois';
                } elseif ($demande->mode_expedition_final == 'avion') {
                    $delaiEstime = '1 à 1,5 mois';
                }
                @endphp

                @if($delaiEstime)
                <div style="background: #fef3c7; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 2px solid #f59e0b;">
                    <h4 style="color: #92400e; margin: 0 0 10px 0;">Délai Standard</h4>
                    <p style="color: #78350f; margin: 0;">
                        Mode {{ $demande->mode_expedition_final }} : <strong>{{ $delaiEstime }}</strong>
                        @if($demande->date_expedition)
                        <br>Date d'expédition : {{ \Carbon\Carbon::parse($demande->date_expedition)->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
                @endif

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('dashboard.import') }}" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #4299e1; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Mettre à Jour le Suivi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const messages = {
            expedition: "Votre marchandise a été expédiée de Chine le {{ now()->format('d/m/Y') }}. Numéro de suivi : {{ $demande->numero_suivi ?? '[À compléter]' }}. Suivi en cours.",
            transit: "Votre marchandise est actuellement en transit vers le Cameroun. L'acheminement se déroule normalement selon les délais prévus.",
            douane: "Votre marchandise est arrivée au port/aéroport et est actuellement en cours de dédouanement. Nous vous tiendrons informé de l'évolution.",
            arrivee: "Votre marchandise est arrivée et a passé la douane avec succès. Elle est maintenant prête pour la livraison ou la récupération."
        };

        function remplirMessage(type) {
            const textarea = document.querySelector('textarea[name="informations_suivi"]');
            textarea.value = messages[type];
            textarea.focus();
        }
    </script>
</section>

@endsection