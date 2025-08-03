{{-- resources/views/emails/compte-active.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Activé</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0; font-size: 2rem; font-weight: bold;">🎉 Félicitations !</h1>
            <p style="margin: 10px 0 0 0; font-size: 1.1rem; opacity: 0.9;">Votre compte a été activé avec succès</p>
        </div>

        <!-- Content -->
        <div style="padding: 40px 30px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #48bb78, #38a169); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                    ✅
                </div>
            </div>

            <h2 style="color: #2d3748; margin-bottom: 20px; text-align: center;">Bonjour {{ $prenom }} {{ $nom }},</h2>
            
            <p style="color: #4a5568; line-height: 1.6; margin-bottom: 20px; font-size: 1rem;">
                Nous avons le plaisir de vous informer que votre demande de création de compte a été <strong style="color: #48bb78;">approuvée et activée</strong> par notre équipe.
            </p>

            <div style="background: #f7fafc; border-left: 4px solid #48bb78; padding: 20px; margin: 25px 0; border-radius: 0 8px 8px 0;">
                <h3 style="color: #2d3748; margin: 0 0 15px 0; font-size: 1.1rem;">📋 Informations de votre compte :</h3>
                <ul style="color: #4a5568; margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li><strong>Nom complet :</strong> {{ $nom }} {{ $prenom }}</li>
                    <li><strong>Numéro CNI :</strong> {{ $compte->cni }}</li>
                    <li><strong>Date d'activation :</strong> {{ $date_activation }}</li>
                    <li><strong>Statut :</strong> <span style="color: #48bb78; font-weight: bold;">✅ ACTIF</span></li>
                </ul>
            </div>

            <div style="background: linear-gradient(135deg, #e6fffa, #b2f5ea); border: 1px solid #81e6d9; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #234e52; margin: 0 0 10px 0; font-size: 1.1rem;">🚀 Prochaines étapes :</h3>
                <ul style="color: #285e61; margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li>Vous pouvez maintenant accéder à tous nos services</li>
                    <li>Votre compte est pleinement fonctionnel</li>
                    <li>En cas de questions, contactez notre support</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/dashboard') }}" 
                   style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; text-decoration: none; padding: 15px 30px; border-radius: 8px; font-weight: bold; display: inline-block; font-size: 1rem; transition: all 0.3s;">
                    🏠 Accéder à mon espace
                </a>
            </div>

            <p style="color: #718096; font-size: 0.9rem; line-height: 1.6; margin-top: 30px;">
                Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter. Notre équipe est là pour vous accompagner.
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #2d3748; color: white; padding: 25px; text-align: center;">
            <p style="margin: 0 0 10px 0; font-size: 1rem; font-weight: bold;">{{ config('app.name', 'Notre Plateforme') }}</p>
            <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">
                Merci de votre confiance | © {{ date('Y') }} Tous droits réservés
            </p>
            <div style="margin-top: 15px;">
                <span style="font-size: 0.8rem; opacity: 0.7;">
                    📧 Besoin d'aide ? Contactez-nous à support@example.com
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