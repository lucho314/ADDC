<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Mesa_plano extends Model {

    protected $table = 'plano';
    protected $connection = 'plano';

    public static function get($dpto, $plano) {
       return Mesa_plano::select('fecha_registro', 'perito','propietario', 'gestor', 'corrector', 'id')
                ->where('Dpto', '=', $dpto)
                ->where('plano', '=', $plano)
                ->first();
    }
    public function getFechaRegistroAttribute($value){
       $arrayFecha= explode('/', $value);
       $fecha=($arrayFecha[2]>90)?'19'.$arrayFecha[2]:'20'.$arrayFecha[2];
       $fecha.='-'.$arrayFecha[1].'-'.$arrayFecha[0];
       return $fecha;
    }
    

}
