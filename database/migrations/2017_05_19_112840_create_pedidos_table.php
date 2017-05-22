<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nro_dpto');
            $table->unsignedInteger('nro_plano');
            $table->unsignedInteger('tipo_doc');
            $table->unsignedInteger('user_pedido_id');
            $table->string('detalle_pedido')->nullable();
            $table->timestamp('fecha_pedido');
            $table->boolean('terminado')->default(0);
            $table->timestamp('fecha_terminado')->nullable();
            $table->string('observaciones')->nullable();
            $table->unsignedInteger('user_atendio_id')->nullable();
            $table->foreign('user_pedido_id')->references('id')->on('tbl_users');
            $table->foreign('user_atendio_id')->references('id')->on('tbl_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pedidos');
    }
}
