<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensuraEspecialsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_mensura_especials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inscripcion')->nullable();
            $table->integer('tipo_planta_id')->nullable();
            $table->string('sup_mensura')->nullable();
            $table->string('sup_titulo')->nullable();
            $table->string('exceso')->nullable();
            $table->string('sup_edificada')->nullable();
            $table->integer('localidad_id');
            $table->integer('distrito_id');
            $table->integer('departamento_id');
            $table->string('seccion')->nullable();
            $table->string('grupo')->nullable();
            $table->string('manzana')->nullable();
            $table->string('parcela')->nullable();
            $table->string('subparcela')->nullable();
            $table->string('lamina')->nullable();
            $table->string('sublamina')->nullable();
            $table->string('chacra')->nullable();
            $table->string('quinta')->nullable();
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_mensura_especials');
    }

}
