<?php

use Illuminate\Database\Seeder;

class carga_tipo_documento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('tipo_docs')->insert([
                ['descripcion' => 'Plano de mensura'],
                ['descripcion' => 'Ficha de transferencia'],
             ]);
    }
}
