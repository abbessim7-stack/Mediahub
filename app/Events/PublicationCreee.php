<?php

namespace App\Events;

use App\Models\Publication;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicationCreee
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // We pass the publication to the event
    public function __construct(public Publication $publication)
    {
    }
}
