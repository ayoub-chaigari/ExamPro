@extends('emails.layout')

@section('content')
    <div style="background-color: #2563eb; padding: 20px; border-radius: 12px; margin-bottom: 20px; color: #ffffff; text-align: center;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 700;">
            Notification Administrateur
        </h2>
    </div>
    
    <p style="margin: 0 0 20px; font-size: 16px; color: #475569;">
        Un nouveau rendez-vous a été enregistré sur la plateforme.
    </p>
    
    <div style="background-color: #f1f5f9; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
        <h3 style="margin: 0 0 15px; font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.05em;">
            Détails du client
        </h3>
        <p style="margin: 0 0 10px; font-size: 14px; color: #64748b;">
            <strong>Nom :</strong> {{ $appointment['user_name'] ?? 'Inconnu' }}
        </p>
        <p style="margin: 0 0 10px; font-size: 14px; color: #64748b;">
            <strong>Email :</strong> {{ $appointment['user_email'] ?? 'Inconnu' }}
        </p>
        
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 15px 0;">
        
        <h3 style="margin: 0 0 15px; font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.05em;">
            Détails du rendez-vous
        </h3>
        <p style="margin: 0 0 10px; font-size: 14px; color: #64748b;">
            <strong>Date :</strong> {{ $appointment['date'] ?? 'N/A' }}
        </p>
        <p style="margin: 0 0 10px; font-size: 14px; color: #64748b;">
            <strong>Heure :</strong> {{ $appointment['time'] ?? 'N/A' }}
        </p>
        <p style="margin: 0; font-size: 14px; color: #64748b;">
            <strong>Service :</strong> {{ $appointment['service'] ?? 'N/A' }}
        </p>
    </div>
    
    <div style="text-align: center;">
        <a href="{{ config('app.url') }}/admin/appointments" class="button">
            Gérer les rendez-vous
        </a>
    </div>
@endsection
