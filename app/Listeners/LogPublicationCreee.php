<?php

namespace App\Listeners;

use App\Events\PublicationCreee;
use Illuminate\Support\Facades\Log;

class LogPublicationCreee
{
    public function handle(PublicationCreee $event): void
    {
        // Write to the Laravel log file when this event is triggered
        Log::info('Nouvelle publication créée', [
            'id' => $event->publication->id,
            'titre' => $event->publication->titre,
            'auteur_id' => $event->publication->user_id
        ]);
    }
}
