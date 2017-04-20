<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogCambio extends Model
{
    protected $guarded=[];
    public $timestamps = false;

    public static function insertarCambios($datos){
    	LogCambio::updateOrCreate(
    		['nombre'=>$datos->nombre,'campo'=>$datos->campo],
    		['nombre'=>$datos->nombre,
    		'campo'=>$datos->campo,
    		'val_original'=>$datos->val_original,
    		'val_cambio'=>$datos->val_cambio]);
    }
}
