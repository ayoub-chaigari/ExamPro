<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // 1. Afficher le formulaire de demande de lien
    public function showLinkRequestForm()
    {
        return view('auth.custom-forgot-password');
    }

    // 2. Envoyer l'email de réinitialisation
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Générer un token unique
        $token = Str::random(64);

        // Sauvegarder le token dans la table password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token, // En production, il est préférable de hasher le token : Hash::make($token)
                'created_at' => Carbon::now()
            ]
        );

        // Envoyer l'email
        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

        return back()->with('status', 'Nous avons envoyé votre lien de réinitialisation par email !');
    }

    // 3. Afficher le formulaire de nouveau mot de passe
    public function showResetForm($token)
    {
        return view('auth.custom-reset-password', ['token' => $token]);
    }

    // 4. Mettre à jour le mot de passe
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Vérifier si le token est valide et n'a pas expiré (ex: 60 min)
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Ce lien de réinitialisation est invalide ou a expiré.']);
        }

        // Mettre à jour le mot de passe de l'utilisateur
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Supprimer le token utilisé
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé !');
    }
}
