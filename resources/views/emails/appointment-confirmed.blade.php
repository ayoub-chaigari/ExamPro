@extends('emails.layout')

@section('content')
    <h2 style="margin: 0 0 20px; font-size: 20px; font-weight: 700; color: #1e293b;">
        Confirmation de rendez-vous
    </h2>
    <p style="margin: 0 0 20px; font-size: 16px; color: #475569;">
        Bonjour {{ $appointment['user_name'] ?? 'Client' }},
    </p>
    <p style="margin: 0 0 20px; font-size: 16px; color: #475569;">
        Votre rendez-vous a été confirmé avec succès. Voici les détails :
    </p>
    <div style="background-color: #f1f5f9; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
        <p style="margin: 0 0 10px; font-size: 14px; color: #64748b;">
            <strong>Date :</strong> {{ $appointment['date'] ?? 'N/A' }}
        </p>
        <p style="margin: 0 0 10px; font-size: 14px; color: #64748b;">
            <strong>Heure :</strong> {{ $appointment['time'] ?? 'N/A' }}
        </p>
        <p style="margin: 0; font-size: 14px; color: #64748b;">
            <strong>Service :</strong> {{ $appointment['service'] ?? 'Consultation' }}
        </p>
    </div>
    <p style="margin: 0 0 20px; font-size: 16px; color: #475569;">
        Vous pouvez gérer votre rendez-vous depuis votre espace personnel.
    </p>
    <div style="text-align: center;">
        <a href="{{ config('app.url') }}/dashboard" class="button">
            Voir mon tableau de bord
        </a>
    </div>
@endsection
