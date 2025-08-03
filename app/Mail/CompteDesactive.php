<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Compte;

class CompteDesactive extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $compte;
    public $raison;

    /**
     * Create a new message instance.
     */
    public function __construct(Compte $compte, $raison = null)
    {
        $this->compte = $compte;
        $this->raison = $raison;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.compte-desactive')
                    ->subject('⚠️ Votre compte a été suspendu')
                    ->with([
                        'nom' => $this->compte->nom,
                        'prenom' => $this->compte->prenom,
                        'date_desactivation' => now()->format('d/m/Y à H:i'),
                        'raison' => $this->raison,
                        'compte' => $this->compte
                    ]);
    }
}