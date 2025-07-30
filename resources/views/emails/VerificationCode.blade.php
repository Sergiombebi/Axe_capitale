<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .title {
            color: #1f2937;
            margin-bottom: 10px;
        }
        .verification-code {
            background-color: #f3f4f6;
            border: 2px dashed #3b82f6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            color: #3b82f6;
            letter-spacing: 5px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">AC</div>
            <h1 class="title">Axe Capital</h1>
            <p>Vérification de votre adresse email</p>
        </div>

        <h2>Bonjour {{ $user->name }},</h2>

        <p>Merci de vous être inscrit sur <strong>Axe Capital</strong> !</p>
        
        <p>Pour finaliser votre inscription et sécuriser votre compte, veuillez utiliser le code de vérification ci-dessous :</p>

        <div class="verification-code">
            <p><strong>Votre code de vérification :</strong></p>
            <div class="code">{{ $verification_code}}</div>
            <p><small>Ce code expire dans 15 minutes</small></p>
        </div>

        <p>Saisissez ce code sur la page de vérification pour activer votre compte.</p>

        <div class="warning">
            <strong>⚠️ Important :</strong>
            <ul>
                <li>Ce code est personnel et confidentiel</li>
                <li>Ne le partagez avec personne</li>
                <li>Il expire dans 15 minutes</li>
                <li>Si vous n'avez pas demandé cette vérification, ignorez cet email</li>
            </ul>
        </div>

        <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>

        <p>Cordialement,<br>
        <strong>L'équipe Axe Capital</strong></p>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} Axe Capital. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>