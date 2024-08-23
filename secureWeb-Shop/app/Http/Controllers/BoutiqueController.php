<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;

class BoutiqueController extends Controller
{
    // Affiche la liste des boutiques
    public function index()
    {
    
        $boutiques = Boutique::where('user_id', auth()->id())->get();
        return view('boutiques.index', compact('boutiques'));
    }

    // Affiche le formulaire de création de boutique
    public function create()
    {
        return view('boutiques.create');
    }

    // Stocke une nouvelle boutique
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        // Créer une nouvelle boutique avec l'utilisateur authentifié comme propriétaire
        Boutique::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
         // Assigner l'ID de l'utilisateur authentifié
        ]);
    
        // Rediriger vers la liste des boutiques avec un message de succès
        return redirect()->route('boutiques.index')->with('success', 'Boutique créée avec succès.');
    }

    // Affiche les détails d'une boutique spécifique
    public function show(Boutique $boutique)
    {
        return view('boutiques.show', compact('boutique'));
    }

    // Affiche le formulaire d'édition d'une boutique spécifique
    public function edit(Boutique $boutique)
    {
        return view('boutiques.edit', compact('boutique'));
    }

    // Met à jour une boutique existante
    public function update(Request $request, Boutique $boutique)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $boutique->update($request->all());

        return redirect()->route('boutiques.index')->with('success', 'Boutique mise à jour avec succès.');
    }

    // Supprime une boutique
    public function destroy(Boutique $boutique)
    {
        $boutique->delete();

        return redirect()->route('boutiques.index')->with('success', 'Boutique supprimée avec succès.');
    }
}
