<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données
        $request->validate([
            'user_id' => 'required',
            'reservation_id' => 'required',
            // 'date_visite' => 'required|date',
        ]);

        // Créer un nouvel historique
        $historique = new Historique([
            'user_id' => $request->user_id,
            'reservation_id' => $request->reservation_id,
            // 'date_visite' => $request->date_visite,
        ]);

        // Sauvegarder l'historique
        $historique->save();

        // Retourner une réponse JSON
        return response()->json($historique, 201);
    }



// public function index()
// {
//     $historiques = Historique::with('reservation.menu','reservation.user')->get();

//     return response()->json($historiques);
// }

public function index()
{
    // Récupérer tous les historiques avec leurs relations
    $historiques = Historique::with('user', 'reservation.menu')->get();

    // Transformer les résultats pour le format souhaité
    $formattedHistoriques = $historiques->map(function ($historique) {
        return [
            'id' => $historique->id,
            'user_id' => $historique->user_id,
            'reservation' => [
                'id' => $historique->reservation_id,
                'user' => $historique->reservation->user,
                'menu' => $historique->reservation->menu,
                'date_reservation' => $historique->reservation->date_reservation,
                'nombre_personnes' => $historique->reservation->nombre_personnes,
                'soldes' => $historique->reservation->soldes,
                'created_at' => $historique->reservation->created_at,
                'updated_at' => $historique->reservation->updated_at,
            ],
            'created_at' => $historique->created_at,
            'updated_at' => $historique->updated_at,
        ];
    });

    // Retourner une réponse JSON avec les historiques
    return response()->json($formattedHistoriques);
}


}
