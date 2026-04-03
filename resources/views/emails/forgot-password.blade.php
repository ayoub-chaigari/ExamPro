@extends('emails.layout')

@section('content')
    <h2 style="margin: 0 0 20px; font-size: 20px; font-weight: 700; color: #1e293b;">
        Bonjour {{ $name }},
    </h2>
    <p style="margin: 0 0 20px; font-size: 16px; color: #475569;">
        Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.
    </p>
    <div style="text-align: center;">
        <a href="{{ $url }}" class="button">
            Réinitialiser mon mot de passe
        </a>
    </div>
    <p style="margin: 20px 0 0; font-size: 16px; color: #475569;">
        Ce lien de réinitialisation de mot de passe expirera dans 60 minutes.
    </p>
    <p style="margin: 10px 0 0; font-size: 16px; color: #475569;">
        Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.
    </p>
    
    <div class="divider"></div>
    
    <p style="font-size: 12px; color: #94a3b8; word-break: break-all;">
        Si vous éprouvez des difficultés à cliquer sur le bouton "Réinitialiser mon mot de passe", copiez et collez l'URL ci-dessous dans votre navigateur Web : <br>
        <a href="{{ $url }}" style="color: #2563eb;">{{ $url }}</a>
    </p>
@endsection
