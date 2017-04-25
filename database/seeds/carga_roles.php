<?php

use Illuminate\Database\Seeder;

class carga_roles extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->insert([
                ['id' => '1', 'key' => 'admin', 'nombre' => 'Administrador'],
                ['id' => '3', 'key' => 'corrector', 'nombre' => 'Corrector'],
                ['id' => '4', 'key' => 'validador', 'nombre' => 'Validador de documentos'],
                ['id' => '5', 'key' => 'carga', 'nombre' => 'carga de documentos']
                ]
        );
    }

}
