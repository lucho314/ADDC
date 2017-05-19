<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dpto');
            $table->integer('numero_caja');
            $table->integer('tipo_doc');
            $table->integer('sector');
            $table->integer('modulo');
            $table->integer('estante');
            $table->integer('posicion');
            $table->integer('profundidad');
            $table->boolean('completo');
            $table->boolean('activo')->default('1');
            $table->string('usuario_alta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_cajas');
    }
}
