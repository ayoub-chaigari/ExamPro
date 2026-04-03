<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation de mot de passe</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; rounded-lg;">
        <h2 style="color: #1E3A8A;">Bonjour,</h2>
        <p>Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('reset-password/'.$token.'?email='.$email) }}" 
               style="background-color: #1E3A8A; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Réinitialiser mon mot de passe
            </a>
        </div>
        <p>Ce lien de réinitialisation expirera dans 60 minutes.</p>
        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #771;">
            Si vous avez des difficultés à cliquer sur le bouton "Réinitialiser mon mot de passe", copiez et collez l'URL ci-dessous dans votre navigateur web :<br>
            <span style="color: #1E3A8A;">{{ url('reset-password/'.$token.'?email='.$email) }}</span>
        </p>
    </div>
</body>
</html>
