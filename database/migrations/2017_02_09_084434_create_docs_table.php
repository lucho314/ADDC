<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('docs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_doc');
            $table->string('nro_dpto');
            $table->integer('nro_plano');
            $table->integer('nro_plano_hasta')->nullable();
            $table->integer('nro_matricula')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('sup_mensura')->nullable();
            $table->string('sup_titulo')->nullable();
            $table->string('exeso')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('responsable')->nullable();
            $table->integer('objeto_id')->nullable();
          //  $table->longText('linderos')->nullable();
            $table->boolean('bis')->default('0');
            $table->string('usuario_alta');
            $table->string('usuario_ultima_mod');
            $table->integer('ubicacion_fisica_id')->nullable();
            $table->integer('estado');
            $table->timestamp('fecha_baja')->nullable();
            $table->string('observaciones')->nullable();
            $table->binary('imagen')->nullable();
            $table->string('checksum')->nullable();
            $table->string('usuario_actual')->nullable();
            $table->timestamps();
            $table->index(['nro_plano', 'nro_dpto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('docs');
    }


}
