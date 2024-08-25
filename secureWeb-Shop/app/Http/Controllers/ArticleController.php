<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Affiche la liste des articles
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())->get();
        return view('articles.index', compact('articles'));
    }

    // Affiche le formulaire de création d'un article
    public function create()
    {
        $boutiques = Boutique::where('user_id', auth()->id())->get();
        return view('articles.create', compact('boutiques'));
    }

    // Stocke un nouvel article
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'boutique_id' => 'required|exists:boutiques,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validation de l'image
    ]);

    $article = new Article($request->except('image')); // Exclure l'image du tableau pour l'ajout
    $article->user_id = auth()->id(); // Associe l'article à l'utilisateur connecté

    // Traitement de l'image si elle est présente
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageContents = file_get_contents($image->getRealPath()); // Lire le contenu du fichier image
        $base64Image = base64_encode($imageContents);
        $encryptedImage = Crypt::encrypt($base64Image);

        // Sauvegarder l'image cryptée dans le répertoire public (ou ailleurs selon vos besoins)
        $directory = 'img/uploads/' . date('Y/m/d');
        $path = public_path($directory);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $encryptedImagePath = $directory . '/' . time() . '.enc'; // Nom du fichier crypté
        file_put_contents(public_path($encryptedImagePath), $encryptedImage); // Sauvegarder l'image cryptée

        // Enregistrer le chemin du fichier crypté
        $article->image_path = asset($encryptedImagePath);
        $article->encrypted_image = $encryptedImage; // Optionnel : Sauvegarder l'image cryptée
    }

    $article->save();

    return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
}



    // Affiche les détails d'un article spécifique
    public function show(Article $article)
{
    // Décryptage et création d'une image temporaire
    $imageData = $article->encrypted_image;
    if ($imageData) {
        $base64Image = Crypt::decrypt($imageData);
        $imageContents = base64_decode($base64Image);

        $tempImagePath = public_path('temp_image.png');
        file_put_contents($tempImagePath, $imageContents);
        $imageUrl = asset('temp_image.png');
    } else {
        $imageUrl = null;
    }

    // Passe l'URL de l'image temporaire à la vue
    return view('articles.show', [
        'article' => $article,
        'imageUrl' => $imageUrl,
        'users' => User::all()
    ]);
}


    // Affiche le formulaire d'édition d'un article spécifique
    public function edit(Article $article)
    {
        $boutiques = Boutique::all();
        return view('articles.edit', compact('article', 'boutiques'));
    }

    // Met à jour un article existant
    

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'boutique_id' => 'required|exists:boutiques,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validation de l'image
        ]);

        $article->update($request->except('image'));

        // Si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContents = file_get_contents($image->getRealPath()); // Lire le contenu du fichier image
            $base64Image = base64_encode($imageContents);
            $encryptedImage = Crypt::encrypt($base64Image);

            // Sauvegarder l'image cryptée dans le répertoire public (ou ailleurs selon vos besoins)
            $directory = 'img/uploads/' . date('Y/m/d');
            $path = public_path($directory);

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $encryptedImagePath = $directory . '/' . time() . '.enc'; // Nom du fichier crypté
            file_put_contents(public_path($encryptedImagePath), $encryptedImage); // Sauvegarder l'image cryptée

            // Mise à jour de l'image de l'article
            $article->image_path = asset($encryptedImagePath);
            $article->encrypted_image = $encryptedImage; // Optionnel : Sauvegarder l'image cryptée
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }


    // Supprime un article
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    // Partage un article
    public function share(Request $request, Article $article)
    {
        $request->validate([
            'share_type' => 'required|in:public,private',
            'shared_with_user_id' => 'nullable|exists:users,id',
        ]);

        $article->update([
            'share_type' => $request->input('share_type'),
            'shared_with_user_id' => $request->input('share_type') === 'private' ? $request->input('shared_with_user_id') : null,
        ]);

        return redirect()->route('articles.show', $article->id)->with('success', 'Article partagé avec succès.');
    }
}
