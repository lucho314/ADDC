<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogCambiosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_log_cambios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documento_id');
            $table->string('campo');
            $table->string('val_original')->nullable();
            $table->string('val_cambio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_log_cambios');
    }

}
