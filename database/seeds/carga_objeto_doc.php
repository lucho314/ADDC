<?php

use Illuminate\Database\Seeder;
class carga_objeto_doc extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('tbl_objetos')->insert([
            ['descripcion'=>'Mensura'],
            ['descripcion'=>'Prescripción'],
            ['descripcion'=>'Subdivisión Parcelaria'],
            ['descripcion'=>'Servidumbre de Tránsito'],
            ['descripcion'=>'Servidumbre de Electroducto'],
            ['descripcion'=>'Servidumbre de Gasoducto'],
            ['descripcion'=>'Propiedad Horizontal'],
            ['descripcion'=>'Derecho Real de Superficie Forestal']
        ]);
    }

}
