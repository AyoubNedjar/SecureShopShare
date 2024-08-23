<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;
use App\Models\Article;
use App\Models\Moderation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les boutiques de l'utilisateur authentifié
        $boutiques = Boutique::where('user_id', auth()->id())->get();

        // Récupérer les articles de l'utilisateur authentifié
        $articles = Article::whereHas('boutique', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        // Récupérer les éléments en attente de modération si l'utilisateur est un modérateur
        $pendingModerations = [];
        if (auth()->user()->isModerator()) {
            $pendingModerations = Moderation::where('status', 'pending')->get();
        }

        // Passer les données à la vue du tableau de bord
        return view('dashboard', [
            'boutiques' => $boutiques,
            'articles' => $articles,
            'pendingModerations' => $pendingModerations,
        ]);
    }
}
