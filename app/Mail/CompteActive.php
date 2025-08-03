<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Compte;

class CompteActive extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $compte;

    /**
     * Create a new message instance.
     */
    public function __construct(Compte $compte)
    {
        $this->compte = $compte;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.compte-active')
                    ->subject('🎉 Votre compte a été activé')
                    ->with([
                        'nom' => $this->compte->nom,
                        'prenom' => $this->compte->prenom,
                        'date_activation' => now()->format('d/m/Y à H:i'),
                        'compte' => $this->compte
                    ]);
    }
}