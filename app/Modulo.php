<?php

namespace App;

use App\Caja;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model {

    //Select * From Modulos Where Nro_Sector=4 And Nro_Modulo Not In (Select Modulo From Cajas Where Sector=4 Group By Modulo  Having Count(*)>=176 Or  Count(*)=120)


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
