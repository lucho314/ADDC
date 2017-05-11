<?php

use Illuminate\Database\Seeder;

class carga_usuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                 'id'=>'1',
                'nom_usuario' => 'CB25907280',
                 'password'=>'a',
                  'email'=>'a',
                  'area_id'=>'1',
                  'nombre'=>'leo'
                 ]);
    }
}
