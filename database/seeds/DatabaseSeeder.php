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
        
    }

}
