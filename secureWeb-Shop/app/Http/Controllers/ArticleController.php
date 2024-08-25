<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Boutique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use phpseclib3\Crypt\RSA;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $boutiques = Boutique::where('user_id', auth()->id())->get();
        return view('articles.create', compact('boutiques'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'boutique_id' => 'required|exists:boutiques,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = auth()->user();
        $publicKey = RSA::load($user->public_key);

        $article = new Article();
        $article->user_id = $user->id;
        $article->title = $publicKey->encrypt($request->input('title'));
        $article->description = $publicKey->encrypt($request->input('description'));
        $article->price = $publicKey->encrypt($request->input('price'));
        $article->boutique_id = $request->input('boutique_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContents = file_get_contents($image->getRealPath());
            $base64Image = base64_encode($imageContents);
            $encryptedImage = $publicKey->encrypt($base64Image);
            $article->encrypted_image = $encryptedImage;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    public function show(Article $article)
    {
        $user = auth()->user();
        $privateKey = RSA::load(Crypt::decryptString($user->private_key));

        $article->title = $privateKey->decrypt($article->title);
        $article->description = $privateKey->decrypt($article->description);
        $article->price = $privateKey->decrypt($article->price);

        $imageUrl = null;

        if ($article->encrypted_image) {
            try {
                $base64Image = $privateKey->decrypt($article->encrypted_image);
                $imageContents = base64_decode($base64Image);

                // Créer un chemin d'image temporaire
                $tempImagePath = public_path('temp_image.png');
                file_put_contents($tempImagePath, $imageContents);
                $imageUrl = asset('temp_image.png');
            } catch (\Exception $e) {
                \Log::error('Erreur de déchiffrement de l\'image :', ['exception' => $e]);
                $imageUrl = null;
            }
        }

        return view('articles.show', [
            'article' => $article,
            'imageUrl' => $imageUrl,
            'users' => User::all()
        ]);
    }

    public function edit(Article $article)
    {
        $boutiques = Boutique::where('user_id', auth()->id())->get();
        return view('articles.edit', compact('article', 'boutiques'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'boutique_id' => 'required|exists:boutiques,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = auth()->user();
        $publicKey = RSA::load($user->public_key);

        $article->title = $publicKey->encrypt($request->input('title'));
        $article->description = $publicKey->encrypt($request->input('description'));
        $article->price = $publicKey->encrypt($request->input('price'));
        $article->boutique_id = $request->input('boutique_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContents = file_get_contents($image->getRealPath());
            $base64Image = base64_encode($imageContents);
            $encryptedImage = $publicKey->encrypt($base64Image);
            $article->encrypted_image = $encryptedImage;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    public function share(Request $request, Article $article)
    {
        $request->validate([
            'share_type' => 'required|in:public,private',
            'shared_with_user_id' => 'nullable|exists:users,id',
        ]);

        // Mettre à jour les informations de partage de l'article
        $article->update([
            'share_type' => $request->input('share_type'),
            'shared_with_user_id' => $request->input('share_type') === 'private' ? $request->input('shared_with_user_id') : null,
        ]);

        return redirect()->route('articles.show', $article->id)->with('success', 'Article partagé avec succès.');
    }
}
