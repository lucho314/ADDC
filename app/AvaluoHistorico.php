<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as Collection;

class AvaluoHistorico extends Model {

    protected $table = 'Tbl_Grupos_Inf_X_Imponibles';
    protected $primaryKey = 'clave_imponible';
    public $incrementing = false;

    //select Clave_Imponible from Tbl_Grupos_Inf_X_Imponibles where Clave_Imponible like '001-%'
    // and col10='23711' Group by Clave_Imponible;
    public static function getImponibleHistoricoPlano(array $planos, $nro_dpto) {
        $imponible = AvaluoHistorico::select('clave_imponible', 'col10')
                ->where('tipo_imponible', '0005')
                ->where('tipo_grupo_inf', '0003')
                ->where('clave_imponible', 'like', '0' . $nro_dpto . '-%')
                ->whereIn('col10', $planos)
                ->groupBy('clave_imponible', 'col10')
                ->get();

        $inexistente = array_diff($planos, $imponible->pluck('col10')->toArray());

        return (['inexistentes' => $inexistente, 'imponible_historico' => $imponible]);
    }
    
    
    /*

     * SELECT FECHA_ALTA FROM TBL_GRUPOS_INF_X_IMPONIBLES WHERE TIPO_GRUPO_INF='0010' AND TIPO_IMPONIBLE='0005'
and CLAVE_IMPONIBLE='010-0031679-007' and col01='W' and  rownum < 2 
order by rowid asc;
     *      */
    
    public static function getFechaUltimaTranferencia($imponible){
        return AvaluoHistorico::select('fecha_alta')
                                ->where('tipo_grupo_inf','0010')
                                ->where('tipo_imponible','0005')
                                ->where('col01','T')
                                ->where('clave_imponible',"$imponible")
                                ->orderBy('fecha_alta','desc')
                                ->first();
    }

}
