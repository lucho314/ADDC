<?php

use Illuminate\Database\Seeder;

class carga_areas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('areas')->insert([
                ['descripcion' => 'ARCHIVO'],
                ['descripcion' => 'ECONIMICO'],
                ['descripcion' => 'TOPOGRAFICO'],
                ['descripcion' => 'CERTIFICADO'],
                ['descripcion' => 'MESA DE ENTRADA'],
                ['descripcion' => 'COMPUTO'],
                ['descripcion' => 'DIRECCION']
        ]);
    }
}
