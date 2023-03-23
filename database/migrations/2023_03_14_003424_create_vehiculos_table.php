<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('combustible_id')->unsigned();
            $table->bigInteger('clases_vehiculo_id')->unsigned();
            $table->string('placa', 10)->unique();
            $table->string('marca', 100);
            $table->string('modelo', 50);
            $table->string('color', 50);
            $table->string('cilindraje', 50);
            $table->date('fecha_inicio_SOAT');
            $table->date('fecha_fin_SOAT');
            $table->date('fecha_inicio_tecno');
            $table->date('fecha_fin_tecno');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('combustible_id')
                ->references('id')
                ->on('combustibles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('clases_vehiculo_id')
                ->references('id')
                ->on('clases_vehiculo')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
