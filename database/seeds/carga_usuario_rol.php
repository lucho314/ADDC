<?php

use Illuminate\Database\Seeder;

class carga_usuario_rol extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_role_user')->insert([
                'user_id' => '1',
                 'role_id'=>'1'
                 ]);
    }
}
