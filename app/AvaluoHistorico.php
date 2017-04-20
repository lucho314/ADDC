<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvaluoHistorico extends Model {

    protected $table = 'Tbl_Grupos_Inf_X_Imponibles';
    protected $primaryKey = 'clave_imponible';
    public $incrementing = false;

    //select Clave_Imponible from Tbl_Grupos_Inf_X_Imponibles where Clave_Imponible like '001-%'
    // and col10='23711' Group by Clave_Imponible;
    public static function getImponibleHistoricoPlano($nro_plano,$nro_dpto){
        $imponible=AvaluoHistorico::select('clave_imponible')
                                    ->where('clave_imponible','like','0'.$nro_dpto.'-%')
                                    ->where('col10','=',"$nro_plano")
                                    ->groupBy('clave_imponible')
                                    ->first();
        return (is_object($imponible))?$imponible->clave_imponible:'';
    }
}
