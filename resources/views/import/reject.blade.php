@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto;">
        
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 25px;">
                <div style="font-size: 3rem; color: #dc2626; margin-bottom: 15px;">❌</div>
                <h1 style="color: #2d3748; margin: 0 0 10px 0; font-size: 1.8rem; font-weight: 700;">Rejeter le Devis</h1>
                <p style="color: #718096; margin: 0;">
                    {{ $importExport->nom_marchandise }} - {{ $importExport->numero_reference }}
                </p>
            </div>
            
            <form method="POST" action="{{ route('reject.post', $importExport->id) }}">
                @csrf
                
               

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Que souhaitez-vous faire ?
                    </label>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <label style="display: flex; align-items: center;">
                            <input type="radio" name="action" value="recherche_en_cours" checked style="margin-right: 10px;">
                            Rechercher une alternative (nous recommençons la recherche)
                        </label>
                        <label style="display: flex; align-items: center;">
                            <input type="radio" name="action" value="annule" style="margin-right: 10px;">
                            Annuler définitivement la demande
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('status') }}" 
                        style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Retour
                    </a>
                    <button type="submit" 
                        style="background: #dc2626; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Confirmer le Rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection