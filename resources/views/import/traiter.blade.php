{{-- resources/views/gestionnaire/import-export/traiter.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Traitement de la Demande</h1>
                    <p style="color: #718096; margin: 5px 0 0 0; font-size: 1rem;">{{ $demande->numero_reference }} - {{ $demande->nom_marchandise }}</p>
                </div>
                <a href="{{ route('import.export') }}" style="background: #a0aec0; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations de la demande --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0;">Informations de la Demande</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div>
                    
                    <p><strong>Téléphone:</strong> {{ $demande->telephone_livraison }}</p>
                    <p><strong>Ville:</strong> {{ $demande->ville_livraison }}</p>
                </div>
                <div>
                    <p><strong>Produit:</strong> {{ $demande->nom_marchandise }}</p>
                    <p><strong>Catégorie:</strong> {{ ucfirst($demande->categorie) }}</p>
                    <p><strong>Quantité:</strong> {{ $demande->quantite_souhaitee }} {{ $demande->unite_mesure }}</p>
                </div>
                <div>
                    <p><strong>Budget approx.:</strong> {{ $demande->budget_approximatif ? number_format($demande->budget_approximatif, 0, ',', ' ') . ' FCFA' : 'Non spécifié' }}</p>
                    <p><strong>Urgence:</strong> {{ ucfirst($demande->urgence) }}</p>
                    <p><strong>Mode expédition:</strong> {{ $demande->mode_expedition ? ucfirst($demande->mode_expedition) : 'Non spécifié' }}</p>
                </div>
            </div>

            <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; color: #2d3748;">Description</h4>
                <p style="margin: 0; line-height: 1.6;">{{ $demande->description_marchandise }}</p>
            </div>

            @if($demande->exigences_particulieres)
            <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; color: #1e40af;">Exigences Particulières</h4>
                <p style="margin: 0; line-height: 1.6; color: #1e3a8a;">{{ $demande->exigences_particulieres }}</p>
            </div>
            @endif

            {{-- Photos --}}
            @if($demande->photos_marchandise && count($demande->photos_marchandise) > 0)
            <div>
                <h4 style="margin: 0 0 15px 0; color: #2d3748;">Photos de la Marchandise</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                    @foreach($demande->photos_marchandise as $index => $photo)
                    <div style="border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $photo) }}" alt="Photo {{ $index + 1 }}" 
                             style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;" 
                             onclick="window.open('{{ asset('storage/' . $photo) }}', '_blank')">
                        <div style="padding: 8px; background: #f7fafc; text-align: center; font-size: 0.8rem; color: #4a5568;">
                            Photo {{ $index + 1 }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Formulaire de traitement --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 25px 0;">Actions de Traitement</h3>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('traiter.post', $demande->id) }}">
                @csrf
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Décision *
                    </label>
                    <select name="decision" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <option value="">Sélectionner une décision...</option>
                        <option value="recherche_en_cours">Lancer la recherche chez nos fournisseurs</option>
                        <option value="annule">Annuler la demande (produit non disponible)</option>
                    </select>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                        Observations
                    </label>
                    <textarea name="observations" placeholder="Commentaires, notes internes, informations pour le client..." style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('observations') }}</textarea>
                </div>

                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('import.export') }}" style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Annuler
                    </a>
                    <button type="submit" style="background: #48bb78; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Confirmer le traitement
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection