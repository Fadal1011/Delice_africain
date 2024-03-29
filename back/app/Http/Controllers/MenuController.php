<?php

namespace App\Http\Controllers;

use App\Http\Resources\menuResource;
use App\Models\Menu;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $menus = Menu::all();
        return $this->responseData('liste des menu',true,Response::HTTP_OK,menuResource::collection($menus));
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date|after:today', 
            'plats' => 'required|array',
            'plats.*' => 'exists:plats,id'
        ]);

        // Créer un nouveau menu
        $menu = Menu::create([
            'nom' => $request->nom,
            'date' => $request->date,
        ]);

        $menu->plats()->attach($request->plats);
        return $this->responseData('menu ajouté avec succés',true,Response::HTTP_OK,menuResource::make($menu));

    }

    public function show($id)
    {
        // Récupérer le menu spécifique avec les plats associés
        $menu = Menu::with('plats')->findOrFail($id);

        return $this->responseData('menu trouvé',true,Response::HTTP_OK,menuResource::make($menu));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date|after:today', // La date doit être postérieure à aujourd'hui
            'plats' => 'array', // Les plats ne sont pas obligatoires
            'plats.*' => 'exists:plats,id' // Vérifier que tous les plats sélectionnés existent dans la base de données
        ]);

        // Récupérer le menu existant
        $menu = Menu::findOrFail($id);

        // Mettre à jour les champs du menu
        $menu->nom = $request->nom;
        $menu->date = $request->date;

        // Si des plats sont fournis, mettre à jour les plats associés au menu
        if ($request->has('plats')) {
            $menu->plats()->sync($request->plats);
        }

        // Sauvegarder les changements
        $menu->save();

        // Retourner la réponse JSON avec le menu mis à jour
        return $this->responseData('menu modifier avec succées',true,Response::HTTP_OK,menuResource::make($menu));
    }

    public function destroy($id)
    {
        // Récupérer le menu existant
        $menu = Menu::findOrFail($id);

        // Supprimer le menu
        $menu->delete();

        // Retourner une réponse JSON indiquant que le menu a été supprimé avec succès
        return $this->responseData('Menu supprimé avec succès',true,Response::HTTP_OK,menuResource::make($menu));
    }
}
