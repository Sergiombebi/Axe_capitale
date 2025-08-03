{{-- resources/views/emails/compte-desactive.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Suspendu</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #f56565, #e53e3e); color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0; font-size: 2rem; font-weight: bold;">⚠️ Suspension de compte</h1>
            <p style="margin: 10px 0 0 0; font-size: 1.1rem; opacity: 0.9;">Votre compte a été temporairement suspendu</p>
        </div>

        <!-- Content -->
        <div style="padding: 40px 30px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f56565, #e53e3e); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                    ⏸️
                </div>
            </div>

            <h2 style="color: #2d3748; margin-bottom: 20px; text-align: center;">Bonjour {{ $prenom }} {{ $nom }},</h2>
            
            <p style="color: #4a5568; line-height: 1.6; margin-bottom: 20px; font-size: 1rem;">
                Nous vous informons que votre compte a été <strong style="color: #e53e3e;">temporairement suspendu</strong> par notre équipe de gestion.
            </p>

            <div style="background: #fed7d7; border-left: 4px solid #f56565; padding: 20px; margin: 25px 0; border-radius: 0 8px 8px 0;">
                <h3 style="color: #742a2a; margin: 0 0 15px 0; font-size: 1.1rem;">📋 Informations de suspension :</h3>
                <ul style="color: #742a2a; margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li><strong>Nom complet :</strong> {{ $nom }} {{ $prenom }}</li>
                    <li><strong>Numéro CNI :</strong> {{ $compte->cni }}</li>
                    <li><strong>Date de suspension :</strong> {{ $date_desactivation }}</li>
                    <li><strong>Statut :</strong> <span style="color: #e53e3e; font-weight: bold;">⏸️ SUSPENDU</span></li>
                </ul>
            </div>

            @if($raison)
            <div style="background: #fef5e7; border: 1px solid #f6ad55; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #744210; margin: 0 0 10px 0; font-size: 1.1rem;">📝 Motif de la suspension :</h3>
                <p style="color: #744210; margin: 0; line-height: 1.6;">{{ $raison }}</p>
            </div>
            @endif

            <div style="background: linear-gradient(135deg, #e6f3ff, #bee3f8); border: 1px solid #90cdf4; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #2a4365; margin: 0 0 10px 0; font-size: 1.1rem;">🔄 Que faire maintenant ?</h3>
                <ul style="color: #2c5282; margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>Cette suspension est temporaire</li>
                    <li>Vous pouvez contacter notre support pour plus d'informations</li>
                    <li>Une fois les vérifications terminées, votre compte sera réactivé</li>
                    <li>Vos données restent sécurisées pendant cette période</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="mailto:support@example.com?subject=Demande de réactivation - CNI: {{ $compte->cni }}" 
                   style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; text-decoration: none; padding: 15px 30px; border-radius: 8px; font-weight: bold; display: inline-block; font-size: 1rem; transition: all 0.3s;">
                    📧 Contacter le support
                </a>
            </div>

            <div style="background: #fffbf0; border: 1px solid #f6ad55; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h4 style="color: #744210; margin: 0 0 10px 0; font-size: 1rem;">⚡ Important :</h4>
                <p style="color: #744210; margin: 0; font-size: 0.9rem; line-height: 1.6;">
                    Pendant la suspension, l'accès à votre compte est temporairement restreint. 
                    Notre équipe travaille pour résoudre rapidement cette situation.
                </p>
            </div>

            <p style="color: #718096; font-size: 0.9rem; line-height: 1.6; margin-top: 30px;">
                Nous nous excusons pour tout inconvénient causé. Notre équipe support est disponible pour répondre à vos questions et vous accompagner.
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #2d3748; color: white; padding: 25px; text-align: center;">
            <p style="margin: 0 0 10px 0; font-size: 1rem; font-weight: bold;">{{ config('app.name', 'Notre Plateforme') }}</p>
            <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">
                Support client disponible 24h/7j | © {{ date('Y') }} Tous droits réservés
            </p>
            <div style="margin-top: 15px;">
                <span style="font-size: 0.8rem; opacity: 0.7;">
                    📧 Support : support@example.com | 📞 Téléphone : +237 XXX XXX XXX
                </span>
            </div>
        </div>
    </div>

    <!-- Small disclaimer -->
    <div style="text-align: center; margin: 20px 0; color: #a0aec0; font-size: 0.8rem;">
        Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.
    </div>
</body>
</html>