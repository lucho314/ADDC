<?php

use Illuminate\Database\Seeder;

class carga_sectores extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sectores')->insert([
            ['nro_sector'=>1],
            ['nro_sector'=>2],
            ['nro_sector'=>3],
            ['nro_sector'=>4],
            ['nro_sector'=>5]
        ]);
    }
}
