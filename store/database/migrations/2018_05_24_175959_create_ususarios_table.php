<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsusariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ususarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('email');
            $table->string('telefono');
            $table->string('nickname');
            $table->string('password');
            $table->string('id_tipo_usuario');
            $table->string('imagen');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('buyer_state');
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
        Schema::dropIfExists('ususarios');
    }
}
