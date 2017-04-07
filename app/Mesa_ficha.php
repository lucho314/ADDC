<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa_ficha extends Model {

    protected $table = 'Expediente';
    protected $connection = 'certificado';

    public static function get($dpto, $plano,$certif=NULL,$fech=NULL) {
       $datos= Mesa_ficha::select('fecha_registro', 'Perito','Propietario', 'Gestor', 'Corrector','Certificado')
                        ->where('Dpto', '=', $dpto)
                        ->where('Plano', '=', $plano);
        if(!empty($certif)){$datos->where('Certificado','=',$certif);}
        if(!empty($fech)){$datos->where('Fecha_Registro','=',"$fech");}
        return $datos->first();
    }
    
     public function getFechaRegistroAttribute($value){
       $arrayFecha= explode('/', $value);
       $fecha=($arrayFecha[2]>90)?'19'.$arrayFecha[2]:'20'.$arrayFecha[2];
       $fecha.='-'.$arrayFecha[1].'-'.$arrayFecha[0];
       return $fecha;
    }

}
