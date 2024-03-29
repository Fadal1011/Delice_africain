<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'date'];


    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'menu_plat');
    }
}
