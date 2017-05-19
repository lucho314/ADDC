<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table='tbl_modulos';
    
    public static function disponibles($sector) {
        return Modulo::where('nro_sector', '=', $sector)
                ->whereNotIn('nro_modulo', Caja::where('sector', '=', $sector)->select('modulo')
                        ->where('activo','=','1')
                        ->groupBy('modulo')
                        ->havingRaw("count(*)>=176 or count(*)=120")->get()
                )
                ->get();
    }
}
