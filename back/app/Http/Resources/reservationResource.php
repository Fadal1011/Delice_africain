<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class reservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "nombre_personnes"=>$this->nombre_personnes,
            "date_reservation"=>$this->date_reservation,
            "nom"=>$this->nom,
            "email"=>$this->email,
            "numero_telephone"=>$this->numero_telephone,
            "prix_total"=>$this->prix_total,
            "statut"=>$this->statut,
            "heure_reservation"=>$this->heure_reservation,
            "plats"=>platResource::collection($this->plats),
        ];
    }
}
