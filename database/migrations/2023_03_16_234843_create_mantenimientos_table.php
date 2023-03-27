<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehiculo_id')->unsigned();
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('url_foto')->nullable();
            $table->date('fecha');
            $table->string('nombre_mecanico');
            $table->double('precio');
            $table->timestamps();
            $table->foreign('vehiculo_id')
            ->references('id')
            ->on('vehiculos')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantenimientos');
    }
}
