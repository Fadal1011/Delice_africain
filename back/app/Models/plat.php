<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plat extends Model
{
    use HasFactory;

    protected $fillable =[
        "nom",
        "description",
        "prix",
        "image",
        "type_id"
    ];

    // Relation Many-to-Many avec le modèle Menu
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_plat');
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_plat')->withPivot('quantite');
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }
}
