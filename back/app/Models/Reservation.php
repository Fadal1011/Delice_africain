<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;


    protected $fillable = ['nombre_personnes', 'date_reservation', 'nom', 'email', 'numero_telephone', 'prix_total','statut','heure_reservation'];

    // Relation Many-to-Many avec le modèle Plat via la table pivot reservation_plat
    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'reservation_plat')->withPivot('quantite');
    }



}
