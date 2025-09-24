{{-- resources/views/import/export/success.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 800px; width: 100%;">

        {{-- Message de succès --}}
        <div style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="font-size: 4rem; color: #4299e1; margin-bottom: 20px;">🚢</div>
            <h1 style="color: #2d3748; margin: 0 0 15px 0; font-size: 2.2rem; font-weight: 700;">Demande Envoyée avec Succès !</h1>
            <p style="color: #718096; margin: 0 0 25px 0; font-size: 1.1rem; line-height: 1.6;">
                Votre demande d'import pour <strong>"{{ $importExport->nom_marchandise }}"</strong> a été enregistrée.<br>
                Nous allons commencer la recherche chez nos fournisseurs en Chine.
            </p>
            
            <div style="background: #f7fafc; padding: 20px; border-radius: 15px; margin-bottom: 25px;">
                <h3 style="color: #2d3748; margin: 0 0 15px 0;">Numéro de référence</h3>
                <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 15px; border-radius: 10px; font-size: 1.3rem; font-weight: 700; letter-spacing: 2px;">
                    {{ $importExport->numero_reference }}
                </div>
                <p style="color: #718096; margin: 15px 0 0 0; font-size: 0.9rem;">
                    Conservez ce numéro pour le suivi de votre commande
                </p>
            </div>
        </div>

        {{-- Prochaines étapes --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h2 style="color: #2d3748; margin: 0 0 25px 0; text-align: center; font-size: 1.6rem;">Prochaines Étapes</h2>
            
            <div style="display: grid; gap: 20px;">
                <div style="background: #fef3c7; padding: 20px; border-radius: 10px; border-left: 4px solid #f59e0b; display: flex; align-items: center; gap: 15px;">
                    <div style="font-size: 2rem; flex-shrink: 0;">🔍</div>
                    <div>
                        <h4 style="color: #92400e; margin: 0 0 5px 0;">1. Recherche en cours</h4>
                        <p style="color: #78350f; margin: 0; font-size: 0.9rem;">
                            Nous recherchons votre produit chez nos fournisseurs partenaires en Chine.
                        </p>
                    </div>
                </div>
                
                <div style="background: #dbeafe; padding: 20px; border-radius: 10px; border-left: 4px solid #3b82f6; display: flex; align-items: center; gap: 15px;">
                    <div style="font-size: 2rem; flex-shrink: 0;">💰</div>
                    <div>
                        <h4 style="color: #1e40af; margin: 0 0 5px 0;">2. Envoi du devis</h4>
                        <p style="color: #1e3a8a; margin: 0; font-size: 0.9rem;">
                            Nous vous enverrons un devis détaillé avec prix, poids et disponibilité.
                        </p>
                    </div>
                </div>
                
                <div style="background: #dcfce7; padding: 20px; border-radius: 10px; border-left: 4px solid #16a34a; display: flex; align-items: center; gap: 15px;">
                    <div style="font-size: 2rem; flex-shrink: 0;">📞</div>
                    <div>
                        <h4 style="color: #15803d; margin: 0 0 5px 0;">3. Contact sous 48h</h4>
                        <p style="color: #14532d; margin: 0; font-size: 0.9rem;">
                            Notre équipe vous contactera dans les 48 heures maximum.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Récapitulatif de la demande --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; text-align: center;">Récapitulatif de Votre Demande</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Catégorie</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($importExport->categorie) }}</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Quantité</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $importExport->quantite_souhaitee }} {{ $importExport->unite_mesure }}</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Livraison</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($importExport->lieu_livraison) }}</div>
                </div>
                @if($importExport->budget_approximatif)
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Budget</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ number_format($importExport->budget_approximatif, 0, ',', ' ') }} FCFA</div>
                </div>
                @endif
            </div>

            <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                <h4 style="color: #4a5568; margin: 0 0 10px 0; font-size: 1rem;">Description</h4>
                <p style="color: #2d3748; margin: 0; line-height: 1.6;">{{ $importExport->description_marchandise }}</p>
            </div>
        </div>

        {{-- Informations de contact --}}
        <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; border-radius: 15px; padding: 25px; margin-bottom: 30px;">
            <h3 style="margin: 0 0 15px 0; text-align: center;">Notre équipe va vous contacter</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center;">
                <div>
                    <div style="font-size: 1.5rem; margin-bottom: 8px;">📱</div>
                    <div style="font-weight: 600;">WhatsApp</div>
                    <div style="opacity: 0.9;">+237 6XX XXX XXX</div>
                </div>
                <div>
                    <div style="font-size: 1.5rem; margin-bottom: 8px;">📧</div>
                    <div style="font-weight: 600;">Email</div>
                    <div style="opacity: 0.9;">import@axecapital.com</div>
                </div>
                <div>
                    <div style="font-size: 1.5rem; margin-bottom: 8px;">🕒</div>
                    <div style="font-weight: 600;">Délai de réponse</div>
                    <div style="opacity: 0.9;">Max 48 heures</div>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('status') }}" 
                style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s;">
                Suivre Ma Commande
            </a>
            <a href="#" 
                style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s;">
                Retour à l'Accueil
            </a>
        </div>
    </div>
</section>

@endsection