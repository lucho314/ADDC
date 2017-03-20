<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoCambiosEstadosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('documento_cambios_estados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->string('user1_id');
            $table->string('user2_id')->nullable();
            $table->integer('estado_id');
            $table->string('descripcion')->nullable();
            $table->timestamp('fecha_cambio');
            $table->index(['user1_id','user2_id','doc_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('documento_cambios_estados');
    }

}
