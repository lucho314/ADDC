<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContenidosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_desde');
            $table->integer('numero_hasta');
            $table->integer('caja_id');
            $table->string('usuario_alta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contenidos');
    }

}
