<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de Mot de Passe</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .cta-button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 40px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: #5568d3;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .link-text {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
            word-break: break-all;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #667eea;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 13px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #999;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #eee;
            margin: 30px 0;
        }
        .highlight {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔐 Réinitialisation de Mot de Passe</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Bonjour <span class="highlight">{{ $user->username }}</span>,
            </div>

            <div class="message">
                Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe sécurisé.
            </div>

            <div class="button-container">
                <a href="{{ $resetUrl }}" class="cta-button">Réinitialiser mon mot de passe</a>
            </div>

            <div class="warning">
                ⚠️ <strong>Important :</strong> Ce lien expirera dans <strong>{{ $expiresIn }}</strong>. Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.
            </div>

            <div style="margin: 20px 0; font-size: 13px; color: #666;">
                <strong>Ou copiez et collez ce lien dans votre navigateur :</strong>
            </div>

            <div class="link-text">
                {{ $resetUrl }}
            </div>

            <div style="margin-top: 30px; font-size: 13px; color: #999; line-height: 1.8;">
                <p><strong>Questions de sécurité :</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Ne partagez jamais ce lien avec quelqu'un d'autre</li>
                    <li>Ne répondez jamais à une demande de mot de passe par email</li>
                    <li>Utilisez un mot de passe fort et unique</li>
                </ul>
            </div>

            <div class="divider"></div>

            <div style="font-size: 13px; color: #999; margin-top: 20px;">
                Si vous avez besoin d'aide, contactez notre <a href="mailto:support@example.com" style="color: #667eea; text-decoration: none;">équipe de support</a>.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">
                © {{ date('Y') }} Tous droits réservés. | 
                <a href="#">Politique de confidentialité</a> | 
                <a href="#">Conditions d'utilisation</a>
            </p>
            <p style="margin: 10px 0 0 0; font-size: 11px;">
                Cet email a été envoyé à <strong>{{ $user->email }}</strong>
            </p>
        </div>
    </div>
</body>
</html>