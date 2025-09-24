@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto;">
        
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 3rem; color: #15803d; margin-bottom: 20px;">✅</div>
            <h1 style="color: #2d3748; margin: 0 0 15px 0; font-size: 1.8rem; font-weight: 700;">Confirmer le Devis</h1>
            <p style="color: #718096; margin: 0 0 25px 0;">
                Vous êtes sur le point d'accepter le devis pour <strong>{{ $importExport->nom_marchandise }}</strong>
            </p>
            
            <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; margin-bottom: 25px; text-align: left;">
                <h3 style="color: #15803d; margin: 0 0 15px 0;">Récapitulatif</h3>
                <div style="margin-bottom: 10px;">
                    <strong>Prix total :</strong> {{ number_format($importExport->prix_total_marchandise, 0, ',', ' ') }} FCFA
                </div>
                <div style="margin-bottom: 10px;">
                    <strong>Quantité :</strong> {{ $importExport->quantite_finale }} {{ $importExport->unite_mesure }}
                </div>
                <div style="margin-bottom: 10px;">
                    <strong>Frais à l'arrivée :</strong> {{ number_format($importExport->frais_douane_estimes + $importExport->commission_axe_capital, 0, ',', ' ') }} FCFA
                </div>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center;">
                <a href="{{ route('dashboard.import') }}" 
                    style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
                <form method="POST" action="{{ route('confirm.post', $importExport->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" 
                        style="background: #15803d; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Confirmer le Devis
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection