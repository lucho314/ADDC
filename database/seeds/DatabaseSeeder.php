<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(carga_objeto_doc::class);
        $this->call(carga_estados_doc::class);
        $this->call(carga_sectores::class);
        $this->call(carga_tipo_documento::class);
        $this->call(carga_areas::class);
        $this->call(carga_roles::class);
        $this->call(carga_usuario_rol::class);
        $this->call(carga_usuarios::class);
        
    }

}
