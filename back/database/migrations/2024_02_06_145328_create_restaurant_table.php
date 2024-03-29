<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            // Ajoutez d'autres colonnes au besoin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant');
    }
}

