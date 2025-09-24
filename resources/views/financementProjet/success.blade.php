{{-- resources/views/financement/projet/success.blade.php --}}
@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 800px; width: 100%;">

        {{-- Message de succès --}}
        <div style="background: white; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="font-size: 4rem; color: #48bb78; margin-bottom: 20px;">✅</div>
            <h1 style="color: #2d3748; margin: 0 0 15px 0; font-size: 2.2rem; font-weight: 700;">Demande Soumise avec Succès !</h1>
            <p style="color: #718096; margin: 0 0 25px 0; font-size: 1.1rem; line-height: 1.6;">
                Votre demande de financement pour le projet <strong>"{{ $financementProjet->nom_projet }}"</strong> a été enregistrée.
            </p>
            
            <div style="background: #f7fafc; padding: 20px; border-radius: 15px; margin-bottom: 25px;">
                <h3 style="color: #2d3748; margin: 0 0 15px 0;">Numéro de référence</h3>
                <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 15px; border-radius: 10px; font-size: 1.3rem; font-weight: 700; letter-spacing: 2px;">
                    FP-{{ str_pad($financementProjet->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <p style="color: #718096; margin: 15px 0 0 0; font-size: 0.9rem;">
                    Conservez ce numéro pour le suivi de votre dossier
                </p>
            </div>
        </div>

        {{-- Prochaines étapes --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h2 style="color: #2d3748; margin: 0 0 25px 0; text-align: center; font-size: 1.6rem;">Prochaines Étapes</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="background: #fef3c7; padding: 20px; border-radius: 10px; border-left: 4px solid #f59e0b;">
                    <div style="font-size: 1.8rem; margin-bottom: 10px;">💳</div>
                    <h4 style="color: #92400e; margin: 0 0 10px 0;">1. Paiement des Frais</h4>
                    <p style="color: #78350f; margin: 0; font-size: 0.9rem;">
                        Réglez les frais d'étude de <strong>5,000 FCFA</strong> pour lancer l'analyse de votre business plan.
                    </p>
                </div>
                
                <div style="background: #dbeafe; padding: 20px; border-radius: 10px; border-left: 4px solid #3b82f6;">
                    <div style="font-size: 1.8rem; margin-bottom: 10px;">🔍</div>
                    <h4 style="color: #1e40af; margin: 0 0 10px 0;">2. Analyse du Dossier</h4>
                    <p style="color: #1e3a8a; margin: 0; font-size: 0.9rem;">
                        Nos experts analysent votre business plan et votre demande de financement.
                    </p>
                </div>
                
                <div style="background: #dcfce7; padding: 20px; border-radius: 10px; border-left: 4px solid #16a34a;">
                    <div style="font-size: 1.8rem; margin-bottom: 10px;">📞</div>
                    <h4 style="color: #15803d; margin: 0 0 10px 0;">3. Contact</h4>
                    <p style="color: #14532d; margin: 0; font-size: 0.9rem;">
                        Nous vous contacterons dans les <strong>7 jours ouvrables</strong> pour la suite.
                    </p>
                </div>
            </div>
        </div>

        {{-- Récapitulatif du projet --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; text-align: center;">Récapitulatif de Votre Projet</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Secteur</div>
                    <div style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($financementProjet->secteur_activite) }}</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Montant du Projet</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ number_format($financementProjet->montant_total_projet, 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Financement Demandé</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ number_format($financementProjet->montant_financement_demande, 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Apport Personnel</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ number_format($financementProjet->apport_personnel, 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #718096; font-size: 0.9rem; margin-bottom: 5px;">Durée Souhaitée</div>
                    <div style="color: #2d3748; font-weight: 600;">{{ $financementProjet->duree_remboursement }} mois</div>
                </div>
            </div>
        </div>

        {{-- Informations de contact --}}
        <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 15px; padding: 25px; margin-bottom: 30px;">
            <h3 style="margin: 0 0 15px 0; text-align: center;">Besoin d'Aide ?</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center;">
                <div>
                    <div style="font-size: 1.5rem; margin-bottom: 8px;">📧</div>
                    <div style="font-weight: 600;">Email</div>
                    <div style="opacity: 0.9;">contact@axecapital.com</div>
                </div>
                <div>
                    <div style="font-size: 1.5rem; margin-bottom: 8px;">📱</div>
                    <div style="font-weight: 600;">Téléphone</div>
                    <div style="opacity: 0.9;">+237 688 82 22 32</div>
                </div>
                <div>
                    <div style="font-size: 1.5rem; margin-bottom: 8px;">🕒</div>
                    <div style="font-weight: 600;">Horaires</div>
                    <div style="opacity: 0.9;">Lun-Ven : 8h-17h</div>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('projet.status') }}" 
                style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s;">
                Suivre Mon Projet
            </a>
            <a href="#" 
                style="background: #a0aec0; color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-block; transition: all 0.3s;">
                Retour à l'Accueil
            </a>
        </div>
    </div>
</section>

@endsection