<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoAntecedenteTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_antecedente_documento', function (Blueprint $table) {
            $table->integer('documento_id');
            $table->integer('antecedente_id');
            $table->foreign('documento_id')->references('id')->on('tbl_documentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_antecedente_documento');
    }

}
