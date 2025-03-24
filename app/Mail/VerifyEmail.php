<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;  // ✅ Ajout de la variable accessible dans la vue

    /**
     * Créer une nouvelle instance du message.
     */
    public function __construct($user)
    {
        $this->user = $user;

        // ✅ Générer un lien signé avec expiration de 60 minutes
        $this->verificationUrl = URL::temporarySignedRoute(
            'verification.verify', // Assurez-vous que cette route existe bien
            Carbon::now()->addMinutes(60),
            ['id' => $this->user->id]
        );
    }

    /**
     * Construire le message.
     */
    public function build()
    {
        return $this->subject('Confirmez votre adresse e-mail 🏴‍☠️')
                    ->view('emails.verification-code')  // Assurez-vous que ce fichier existe bien
                    ->with([
                        'verificationUrl' => $this->verificationUrl
                    ]);
    }
}
