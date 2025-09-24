@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Confirmer Paiement Frais d'Étude</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">Projet: {{ $projet->nom_projet }}</p>
                </div>
                <a href="{{ route('projet.dashboard') }}" 
                    style="background: #a0aec0; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations du projet --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations du Projet</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Client</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $projet->compte->nom }} {{ $projet->compte->prenom }}</div>
                </div>
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Référence</div>
                    <div style="color: #2d3748; font-weight: 600;">FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Montant Frais</div>
                    <div style="color: #f59e0b; font-weight: 600;">{{ number_format($projet->frais_etude, 0, ',', ' ') }} FCFA</div>
                </div>
                <div>
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Date Demande</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $projet->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                <h4 style="color: #2d3748; margin: 0 0 10px 0;">Description du Projet</h4>
                <p style="color: #718096; margin: 0; line-height: 1.6;">{{ $projet->description_projet }}</p>
            </div>
        </div>

        {{-- Formulaire de confirmation --}}
        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Confirmation du Paiement</h3>
            
            <form method="POST" action="{{ route('valider_paiement', $projet->id) }}">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Date de Paiement *
                    </label>
                    <input type="date" name="date_paiement" value="{{ old('date_paiement', date('Y-m-d')) }}" required
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    @error('date_paiement')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Observations (optionnel)
                    </label>
                    <textarea name="observations" rows="4" placeholder="Notes sur le paiement, mode de paiement utilisé..."
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;">{{ old('observations') }}</textarea>
                    @error('observations')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="background: #fef3c7; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <input type="checkbox" name="confirmation" id="confirmation" required 
                            style="margin-top: 5px;">
                        <label for="confirmation" style="color: #92400e; font-size: 0.9rem; line-height: 1.5;">
                            Je confirme avoir vérifié que les frais d'étude de <strong>{{ number_format($projet->frais_etude, 0, ',', ' ') }} FCFA</strong> 
                            ont bien été payés par le client pour le projet "{{ $projet->nom_projet }}".
                        </label>
                    </div>
                    @error('confirmation')
                    <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 10px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 15px; justify-content: end;">
                    <a href="{{ route('projet.dashboard') }}" 
                        style="background: #a0aec0; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" 
                        style="background: #48bb78; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Confirmer le Paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection