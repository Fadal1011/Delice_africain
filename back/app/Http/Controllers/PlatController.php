<?php

namespace App\Http\Controllers;

use App\Http\Resources\platResource;
use App\Models\plat;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlatController extends Controller
{
    use ResponseTrait;
     // Afficher tous les plats
     public function index()
     {
         $plats = Plat::all();
         return $this->responseData('liste des plat',true,Response::HTTP_OK,platResource::collection($plats));
     }

     // Afficher un plat spécifique
     public function show($id)
     {
         $plat = Plat::findOrFail($id);
         return response()->json($plat);
     }

     // Créer un nouveau plat
     public function store(Request $request)
     {
         $request->validate([
             'nom' => 'required|string|max:255',
             'description' => 'nullable|string',
             'prix' => 'required|numeric',
             'image' => 'nullable',
         ]);

        //  dd($request->type_id);

         $plat = Plat::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'image' => $request->image,
            'type_id' => $request->type_id,
        ]);
         return $this->responseData('Ajout Plat effectue',true,Response::HTTP_OK,$plat);
     }

     // Mettre à jour un plat
     public function update(Request $request, $id)
     {
         $request->validate([
             'nom' => 'string|max:255',
             'description' => 'string',
             'prix' => 'numeric',
             'image' => 'nullable',
         ]);

         $plat = plat::findOrFail($id);
         $plat->update([
         'nom' => $request->filled('nom') ? $request->nom : $plat->nom,
         'description' => $request->filled('description') ? $request->description : $plat->description,
         'prix' => $request->filled('prix') ? $request->prix : $plat->prix,
         'image' => $request->filled('image') ? $request->image : $plat->image,
         'type_id' => $request->filled('type_id') ? $request->type_id : $plat->type_id,
         ]);
         return $this->responseData('Mise a jour du plat effectué',true,Response::HTTP_OK,$plat);
     }

     // Supprimer un plat
     public function destroy($id)
     {
         $plat = Plat::findOrFail($id);
         $plat->delete();
         return $this->responseData('Plat supprimer avec succées',true,Response::HTTP_OK,$plat);

     }

        public function getByType($id)
    {
        $plats = Plat::where('type_id', $id)->get();
        return $this->responseData('Liste des plats par type', true, Response::HTTP_OK, platResource::collection($plats));
    }
}
