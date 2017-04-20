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
        Schema::create('mensura_especials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nro_dpto');
            $table->integer('nro_partida');
            $table->integer('nro_plano');
            $table->integer('inscripcion');
            $table->integer('tipo_planta_id');
            $table->string('sup_mensura')->nullable();
            $table->string('sup_titulo')->nullable();
            $table->string('exeso')->nullable();
            $table->string('sup_edificada');
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
            $table->string('doc_id');
            $table->index(['nro_plano', 'nro_partida','nro_dpto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('mensura_especials');
    }

}
