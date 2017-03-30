<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa_plano extends Model {

    protected $table = 'plano';
    protected $connection = 'plano';

    public static function get($dpto, $plano) {
       return Mesa_plano::select('Fecha_Registro', 'perito', 'gestor', 'corrector', 'id')
                ->where('Dpto', '=', $dpto)
                ->where('plano', '=', $plano)
                ->first();
    }

}
