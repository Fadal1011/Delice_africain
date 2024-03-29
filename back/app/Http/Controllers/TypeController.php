<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TypeController extends Controller
{
    use ResponseTrait;
    /**
     * Afficher la liste des types de plats.
     */
    public function index()
    {
        $types = Type::all();
        return $this->responseData('liste des types de plats',true,Response::HTTP_OK,$types);
    }

    /**
     * Afficher le formulaire de création d'un nouveau type de plat.
     */
    public function create()
    {
        // Non utilisé dans une API
    }

    /**
     * Enregistrer un nouveau type de plat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:types,nom|max:255',
        ]);

        $type = Type::create($request->all());
        return $this->responseData('type de plat ajouter avec sucées',true,Response::HTTP_OK,$type);
    }

    /**
     * Afficher les détails d'un type de plat spécifique.
     */
    public function show(string $id)
    {
        $type = Type::findOrFail($id);
        return response()->json($type);
    }

    /**
     * Afficher le formulaire de modification d'un type de plat spécifique.
     */
    public function edit(string $id)
    {
        // Non utilisé dans une API
    }

    /**
     * Mettre à jour un type de plat spécifique.
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'nom' => 'required|string|unique:types,nom,' . $type->id . ',id|max:255',
        ]);

        $type->update($request->all());
        return $this->responseData('nom du type de plat mis à jour', true, Response::HTTP_OK, $type);
    }

    /**
     * Supprimer un type de plat spécifique.
     */
    public function destroy(string $id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return $this->responseData('type supprimer avec succées', true, Response::HTTP_OK, $type);
    }
}
