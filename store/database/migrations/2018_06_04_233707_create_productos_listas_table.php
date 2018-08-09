<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosListasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_listas', function (Blueprint $table) {
            $table->increments('id_productos_listas');
            $table->string('id_inventario');
            $table->string('cantidad');
            $table->string('total');
            $table->string('id_lista');
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
        Schema::dropIfExists('productos_listas');
    }
}
