<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Envoie un email test pour vérifier la configuration SMTP';

    public function handle()
    {
        $this->info('Envoi d\'un email test...');
        
        try {
            // Générer un code test
            $code = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
            
            // Envoyer l'email
            Mail::to(config('mail.from.address'))->send(new VerificationCodeMail($code));
            
            $this->info('Email envoyé avec succès !');
            $this->info('Code envoyé : ' . $code);
            
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'envoi de l\'email :');
            $this->error($e->getMessage());
        }
    }
}
