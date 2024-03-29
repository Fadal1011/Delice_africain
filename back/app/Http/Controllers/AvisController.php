<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function index()
    {
        $avis = Avis::with(['user'])->get();
        return response()->json($avis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'restaurant_id' => 'required|exists:restaurants,id',
            'commentaire' => 'required|string',
            'notation' => 'required|integer|between:1,5'
        ]);

        $avis = Avis::create($request->all());
        return response()->json($avis, 201);
    }

    public function show(Avis $avis)
    {
        return response()->json($avis);
    }

    public function update(Request $request, Avis $avis)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'restaurant_id' => 'required|exists:restaurants,id',
            'commentaire' => 'required|string',
            'notation' => 'required|integer|between:1,5'
        ]);

        $avis->update($request->all());
        return response()->json($avis, 200);
    }

    public function destroy(Avis $avis)
    {
        $avis->delete();
        return response()->json(null, 204);
    }
  
    

}
