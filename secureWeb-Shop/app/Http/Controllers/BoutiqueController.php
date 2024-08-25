<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use phpseclib3\Crypt\RSA;

class BoutiqueController extends Controller
{
    public function index()
    {
        $boutiques = Boutique::where('user_id', auth()->id())->get();
        return view('boutiques.index', compact('boutiques'));
    }

    public function create()
    {
        return view('boutiques.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $user = auth()->user();
        $publicKey = RSA::load($user->public_key);

        Boutique::create([
            'user_id' => $user->id,
            'name' => $publicKey->encrypt($request->input('name')),
            'description' => $publicKey->encrypt($request->input('description')),
        ]);

        return redirect()->route('boutiques.index')->with('success', 'Boutique créée avec succès.');
    }

    public function show(Boutique $boutique)
    {
        try {
            $user = auth()->user();
            $encryptedPrivateKey = Crypt::decryptString($user->private_key);

            if (empty($encryptedPrivateKey)) {
                throw new \Exception("La clé privée est vide ou mal déchiffrée.");
            }

            $privateKey = RSA::load($encryptedPrivateKey);

            $boutique->name = $privateKey->decrypt($boutique->name);
            $boutique->description = $privateKey->decrypt($boutique->description);

            $users = User::all();
            return view('boutiques.show', compact('boutique', 'users'));

        } catch (\Exception $e) {
            \Log::error("Erreur lors du déchiffrement de la clé privée ou des données : " . $e->getMessage());
            return response()->view('errors.custom', [], 500);
        }
    }

    public function edit(Boutique $boutique)
    {
        $user = auth()->user();
        $privateKey = RSA::load(Crypt::decryptString($user->private_key));

        $boutique->name = $privateKey->decrypt($boutique->name);
        $boutique->description = $privateKey->decrypt($boutique->description);

        return view('boutiques.edit', compact('boutique'));
    }

    public function update(Request $request, Boutique $boutique)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $user = auth()->user();
        $publicKey = RSA::load($user->public_key);

        $boutique->update([
            'name' => $publicKey->encrypt($request->input('name')),
            'description' => $publicKey->encrypt($request->input('description')),
        ]);

        return redirect()->route('boutiques.index')->with('success', 'Boutique mise à jour avec succès.');
    }

    public function destroy(Boutique $boutique)
    {
        $boutique->delete();

        return redirect()->route('boutiques.index')->with('success', 'Boutique supprimée avec succès.');
    }

    public function share(Request $request, Boutique $boutique)
    {
        $request->validate([
            'share_type' => 'required|in:public,private',
            'shared_with_user_id' => 'nullable|exists:users,id',
        ]);

        $boutique->update([
            'share_type' => $request->input('share_type'),
            'shared_with_user_id' => $request->input('share_type') === 'private' ? $request->input('shared_with_user_id') : null,
        ]);

        return redirect()->route('boutiques.show', $boutique->id)->with('success', 'Boutique partagée avec succès.');
    }
}
