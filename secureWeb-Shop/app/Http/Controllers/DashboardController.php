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
        $userId = auth()->id();

        // Récupérer les boutiques de l'utilisateur authentifié
        $boutiques = Boutique::where('user_id', $userId)->get();

        // Récupérer les articles de l'utilisateur authentifié
        $articles = Article::whereHas('boutique', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Récupérer les éléments en attente de modération si l'utilisateur est un modérateur
        $pendingModerations = [];
        if (auth()->user()->isModerator()) {
            $pendingModerations = Moderation::where('status', 'pending')->get();
        }

        // Récupérer les boutiques partagées publiquement et approuvées
        $publicBoutiques = Boutique::where('share_type', 'public')
            ->where('status', 'approved')
            ->get();

        // Récupérer les articles partagés publiquement et approuvés
        $publicArticles = Article::where('share_type', 'public')
            ->where('status', 'approved')
            ->get();

        // Récupérer les boutiques partagées avec l'utilisateur et approuvées
        $sharedWithUserBoutiques = Boutique::where('share_type', 'private')
            ->where('shared_with_user_id', $userId)
            ->get();

        // Récupérer les articles partagés avec l'utilisateur et approuvés
        $privateArticles = Article::where('share_type', 'private')
            ->where('shared_with_user_id', $userId)
            ->get();

        return view('dashboard', [
            'boutiques' => $boutiques,
            'articles' => $articles,
            'pendingModerations' => $pendingModerations,
            'publicBoutiques' => $publicBoutiques,
            'publicArticles' => $publicArticles,
            'sharedWithUserBoutiques' => $sharedWithUserBoutiques,
            'privateArticles' => $privateArticles,
        ]);
    }
}
