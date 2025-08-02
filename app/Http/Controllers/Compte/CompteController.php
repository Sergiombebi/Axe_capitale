<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompteController extends Controller
{
    /**
     * Enregistrement du compte utilisateur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'cni' => 'required|string|max:100|unique:comptes,cni',
            'photo_cni' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'sexe' => 'required|in:Homme,Femme',
            'telephone' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
            'ville' => 'required|string|max:100',
            'quartier' => 'required|string|max:100',
            'lieudit' => 'nullable|string|max:100',
            'contact_urgence' => 'required|string|max:255',
            'tel_urgence' => 'required|string|max:20',
            'fait_le' => 'required|date',
            'fait_a' => 'required|string|max:255',
        ]);

        // Enregistrer l'image CNI
        $cheminImage = $request->file('photo_cni')->store('cni', 'public');

        // Créer le compte
        $compte = Compte::create([
            'user_id' => Auth::id(),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'cni' => $request->cni,
            'photo_cni' => $cheminImage,
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'pays' => $request->pays,
            'ville' => $request->ville,
            'quartier' => $request->quartier,
            'lieudit' => $request->lieudit,
            'contact_urgence' => $request->contact_urgence,
            'tel_urgence' => $request->tel_urgence,
            'fait_le' => $request->fait_le,
            'fait_a' => $request->fait_a,
            'status' => 'inactif', // Par défaut
        ]);

        return redirect()->back()->with('compte_cree', true);
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'telephone' => 'required|string',
        'ville' => 'required|string',
        'quartier' => 'required|string',
        'sexe' => 'required|in:Homme,Femme',
        'pays' => 'required|string',
        'lieudit' => 'nullable|string',
    ]);

    $compte = Compte::findOrFail($id);

    // Sécurité : s’assurer que c’est bien le compte de l’utilisateur connecté
    if ($compte->user_id !== auth()->id()) {
        abort(403);
    }

    $compte->update($request->only([
        'nom', 'prenom', 'telephone', 'ville', 'quartier', 'sexe', 'pays', 'lieudit'
    ]));

    return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
}

}
