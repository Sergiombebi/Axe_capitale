{{-- resources/views/gestionnaire/credits/traiter.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Traitement du Crédit</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">Demande de {{ $credit->compte->nom }} {{ $credit->compte->prenom }}</p>
                </div>
                <a href="{{ route('credit.dashboard') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations du crédit --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations du Crédit</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <p><strong>Client:</strong> {{ $credit->compte->nom }} {{ $credit->compte->prenom }}</p>
                    <p><strong>CNI:</strong> {{ $credit->compte->cni }}</p>
                    <p><strong>Téléphone:</strong> {{ $credit->compte->telephone }}</p>
                </div>
                <div>
                    <p><strong>Montant demandé:</strong> {{ number_format($credit->montant, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Durée:</strong> {{ $credit->duree }} mois</p>
                    <p><strong>Taux d'intérêt:</strong> {{ $credit->taux_interet }}%</p>
                </div>
                <div>
                    <p><strong>Montant total:</strong> {{ number_format($credit->montant_total_rembourser, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Montant mensuel:</strong> {{ number_format($credit->montant_mensuel, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Objet:</strong> {{ $credit->objet_credit }}</p>
                </div>
            </div>
        </div>

        {{-- Formulaire de traitement --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Traitement de la Demande</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('gestionnaire.credits.traiter.post', $credit->id) }}">
                @csrf
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Décision *
                    </label>
                    <select name="decision" id="decisionSelect" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" onchange="toggleMotifRejet()">
                        <option value="">Sélectionner une décision...</option>
                        <option value="approuve" {{ old('decision') == 'approuve' ? 'selected' : '' }}>Approuver</option>
                        <option value="rejete" {{ old('decision') == 'rejete' ? 'selected' : '' }}>Rejeter</option>
                        <option value="en_etude" {{ old('decision') == 'en_etude' ? 'selected' : '' }}>Mettre en étude</option>
                    </select>
                </div>

                <div id="motifRejetDiv" style="margin-bottom: 25px; {{ old('decision') == 'rejete' ? '' : 'display: none;' }}">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Motif de rejet *
                    </label>
                    <textarea name="motif_rejet" placeholder="Expliquez les raisons du rejet..." style="width: 100%; min-height: 120px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('motif_rejet') }}</textarea>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Observations
                    </label>
                    <textarea name="observations" placeholder="Commentaires ou observations..." style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('observations') }}</textarea>
                </div>

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('gestionnaire.credits.index') }}" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #48bb78; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Confirmer le traitement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleMotifRejet() {
            const select = document.getElementById('decisionSelect');
            const motifDiv = document.getElementById('motifRejetDiv');
            
            if (select.value === 'rejete') {
                motifDiv.style.display = 'block';
            } else {
                motifDiv.style.display = 'none';
            }
        }
    </script>
</section>

@endsection