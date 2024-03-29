<?php

// app/Http/Controllers/ConfigurationController.php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'heure' => 'required|date_format:H',
            'nombre_tables_disponibles' => 'required|integer|min:1',
        ]);

        $configuration = Configuration::create($request->all());

        return response()->json(['message' => 'Configuration created successfully', 'data' => $configuration], 201);
    }




    public function index()
{
    // Récupérer la configuration actuelle
    $configuration = Configuration::where('heure', now()->format('H'))->first();

    if ($configuration) {
        // Si une configuration est trouvée, renvoyer la date et l'heure de la configuration
        return response()->json(['date' => $configuration->heure]);
    } else {
        // Si aucune configuration n'est trouvée, renvoyer un message d'erreur
        return response()->json(['message' => 'Aucune configuration trouvée pour l\'heure actuelle.'], 404);
    }
}

}



