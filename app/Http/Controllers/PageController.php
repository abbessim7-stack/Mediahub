<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
           public function accueil()
    {
        $publications = Publication::with('categorie')->latest()->take(3)->get();
        return view('accueil', compact('publications'));
    }

    public function aPropos()
    {
        return view('a-propos');
    }
}
