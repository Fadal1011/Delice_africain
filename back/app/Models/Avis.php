<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','commentaire', 'notation'];

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function reservation()
    // {
    //     return $this->belongsTo(Reservation::class);
    // }
}                                                                                               
