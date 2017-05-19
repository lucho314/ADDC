<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_usuario')->unique();
            $table->string('email')->unique();
            $table->string('nombre');
            $table->string('password')->nullable();
            $table->integer('area_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tbl_users');
    }

}
