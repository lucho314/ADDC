<?php

use Illuminate\Database\Seeder;

class carga_estados_doc extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('estados')->insert([
                ['descripcion' => 'ACTIVO'],
                ['descripcion' => 'PENDIENTE'],
                ['descripcion' => 'DERIVADO'],
                ['descripcion' => 'EN ESTUDIO'],
                ['descripcion' => 'INACTIVO'],
                ['descripcion' => 'EN FALTA']
        ]);
    }

}
