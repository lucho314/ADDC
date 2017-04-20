<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoSatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_sats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('documento_id');
            $table->string('imponible_id')->nullable();
            $table->integer('mensura_especial_id')->nullable();
            $table->integer('nro_dpto');
            $table->integer('nro_plano');
            $table->integer('nro_partida');
            $table->boolean('vigente')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento_sats');
    }
}
