<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('nombre_personnes');
            $table->date('date_reservation');
            $table->string('nom');
            $table->string('email');
            $table->string('numero_telephone');
            $table->decimal('prix_total');
            $table->string('statut')->default('en_attente');
            $table->time('heure_reservation');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation');
    }
}
