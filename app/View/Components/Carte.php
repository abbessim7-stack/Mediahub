<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Carte extends Component
{
    // On déclare la variable $titre pour pouvoir la recevoir
    public $titre;

    public function __construct($titre)
    {
        $this->titre = $titre;
    }

    public function render()
    {
        return view('components.carte');
    }
}
