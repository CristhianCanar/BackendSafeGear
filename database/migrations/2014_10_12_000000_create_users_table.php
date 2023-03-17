<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rol_id')->unsigned();
            $table->string('nombre', 100);
            $table->string('apellido', 100)->nullable();
            $table->string('telefono', 100)->nullable();
            $table->string('identificacion', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->foreign('rol_id')
            ->references('id')
            ->on('roles')
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
        Schema::dropIfExists('users');
    }
}
