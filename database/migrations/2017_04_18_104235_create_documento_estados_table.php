<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoEstadosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('documento_estados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('documento_id');
            $table->integer('estado_id');
            $table->string('descripcion');
            $table->string('nom_usuario');
            $table->date('fecha');
            $table->integer('area_id')->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('documento_estados');
    }

}
