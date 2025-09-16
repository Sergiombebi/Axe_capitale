{{-- resources/views/gestionnaire/credits/rembourser.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Enregistrer un Remboursement</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $credit->compte->nom }} {{ $credit->compte->prenom }}</p>
                </div>
                <a href="{{ route('credit.dashboard') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Situation du crédit --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Situation du Crédit</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div>
                    <p><strong>Montant initial:</strong> {{ number_format($credit->montant, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Montant total à rembourser:</strong> {{ number_format($credit->montant_total_rembourser, 0, ',', ' ') }} FCFA</p>
                </div>
                <div>
                    <p><strong>Montant remboursé:</strong> {{ number_format($credit->montant_rembourse, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Solde restant:</strong> <span style="color: #f56565; font-weight: 600;">{{ number_format($credit->solde_restant, 0, ',', ' ') }} FCFA</span></p>
                </div>
                <div>
                    <p><strong>Échéances payées:</strong> {{ $credit->echeances_payees ?? 0 }}/{{ $credit->echeances_totales ?? $credit->duree }}</p>
                    <p><strong>Montant mensuel:</strong> {{ number_format($credit->montant_mensuel, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>

            @if($credit->jours_retard > 0)
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <strong>Attention:</strong> Ce crédit est en retard de {{ $credit->jours_retard }} jours.
                @if($credit->penalites > 0)
                Pénalités dues: {{ number_format($credit->penalites, 0, ',', ' ') }} FCFA
                @endif
            </div>
            @endif
        </div>

        {{-- Formulaire de remboursement --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Nouveau Remboursement</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('error'))
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('gestionnaire.credits.rembourser.post', $credit->id) }}">
                @csrf
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Montant remboursé (FCFA) *
                    </label>
                    <input type="number" name="montant" value="{{ old('montant') }}" placeholder="Montant en FCFA" step="1" min="1" max="{{ $credit->solde_restant }}" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <small style="color: #718096;">Maximum: {{ number_format($credit->solde_restant, 0, ',', ' ') }} FCFA</small>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Type de remboursement
                    </label>
                    <select name="type" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" onchange="updateMontantSuggestion()">
                        <option value="partiel" {{ old('type') == 'partiel' ? 'selected' : '' }}>Remboursement partiel</option>
                        <option value="echeance" {{ old('type') == 'echeance' ? 'selected' : '' }}>Échéance mensuelle</option>
                        <option value="total" {{ old('type') == 'total' ? 'selected' : '' }}>Remboursement total</option>
                    </select>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Notes
                    </label>
                    <textarea name="notes" placeholder="Notes sur le remboursement..." style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('notes') }}</textarea>
                </div>

                {{-- Raccourcis de montant --}}
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Montants suggérés
                    </label>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="button" onclick="setMontant('{{ $credit->montant_mensuel }}')" style="background: #4299e1; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem;">
                            Échéance: {{ number_format($credit->montant_mensuel, 0, ',', ' ') }}
                        </button>
                        <button type="button" onclick="setMontant('{{ $credit->solde_restant }}')" style="background: #48bb78; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem;">
                            Solde total: {{ number_format($credit->solde_restant, 0, ',', ' ') }}
                        </button>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('gestionnaire.credits.index') }}" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #48bb78; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Enregistrer le remboursement
                    </button>
                </div>
            </form>
        </div>

        {{-- Historique des remboursements --}}
        @if($credit->remboursements && $credit->remboursements->count() > 0)
        <div style="background: white; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Historique des Remboursements</h3>
            
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
                                @switch($remboursement->type)
                                    @case('partiel')
                                        <span style="background: #feebc8; color: #744210; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Partiel</span>
                                        @break
                                    @case('echeance')
                                        <span style="background: #bee3f8; color: #2a69ac; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Échéance</span>
                                        @break
                                    @case('total')
                                        <span style="background: #c6f6d5; color: #22543d; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">Total</span>
                                        @break
                                @endswitch
                            </td>
                            <td style="padding: 12px; color: #718096;">{{ $remboursement->notes ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <script>
        function setMontant(montant) {
            document.querySelector('input[name="montant"]').value = montant;
        }

        function updateMontantSuggestion() {
            const typeSelect = document.querySelector('select[name="type"]');
            const montantInput = document.querySelector('input[name="montant"]');
            
            if (typeSelect.value === 'echeance') {
                montantInput.value = {{ $credit->montant_mensuel }};
            } else if (typeSelect.value === 'total') {
                montantInput.value = {{ $credit->solde_restant }};
            }
        }
    </script>
</section>

@endsection