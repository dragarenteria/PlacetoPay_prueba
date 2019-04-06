<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documento');
            $table->string('tipo_documento');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email');
            $table->string('telefono');
            $table->integer('direccion_id')->unsigned();
            $table->foreign('direccion_id')->references('id')->on('direccions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
