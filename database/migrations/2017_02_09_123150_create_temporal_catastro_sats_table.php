<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporalCatastroSatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('temporal_catastro_sats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nro_partida');
            $table->string('nro_plano');
            $table->string('nro_matricula');
            $table->string('inscripcion');
            $table->string('tipo_planta');
            $table->string('sup_terreno');
            $table->string('sup_edificada');
            $table->string('localidad');
            $table->string('distrito');
            $table->string('departamento');
            $table->string('seccion')->nullable();
            $table->string('grupo')->nullable();
            $table->string('manzana')->nullable();
            $table->string('parcela')->nullable();
            $table->string('subparcela')->nullable();
            $table->string('lamina')->nullable();
            $table->string('sublamina')->nullable();
            $table->string('chacra')->nullable();
            $table->string('quinta')->nullable();
            $table->string('agua');
            $table->string('gasoducto');
            $table->string('electroducto');
            $table->string('cloaca');
            $table->string('usuario_alta');
            $table->string('imponible_id')->nullable();
            $table->string('catastro_id')->nullable();
            $table->string('doc_id');
            $table->string('estado');
            $table->string('nro_dpto');
            $table->timestamps();
            $table->index(['nro_plano','nro_partida','imponible_id','catastro_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('temporal_catastro_sats');
    }

}
