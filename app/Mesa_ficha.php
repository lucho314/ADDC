<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa_ficha extends Model {

    protected $table = 'Expediente';
    protected $connection = 'certificado';

    public static function get($dpto, $plano) {
        return Mesa_ficha::select('Fecha_Registro', 'Perito', 'Gestor', 'Corrector','Certificado')
                        ->where('Dpto', '=', $dpto)
                        ->where('Plano', '=', $plano)
                        ->get();
    }

}
