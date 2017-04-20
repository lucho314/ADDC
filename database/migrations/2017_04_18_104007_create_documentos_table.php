<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('nro_dpto');
            $table->integer('nro_plano');
            $table->integer('nro_plano_hasta');
            $table->boolean('fecha_registro_visible')->default('0');
            $table->string('checksum');
            $table->integer('objeto_id')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->integer('nro_matricula')->nullable();
            $table->binary('imagen');
            $table->integer('certificado')->nullable();
            $table->integer('estado_id');
            $table->integer('tipo_doc_id');
            $table->string('usuario_alta');
            $table->string('usuario_ultima_mod');
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('documentos');
    }

}
