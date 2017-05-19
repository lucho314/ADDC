<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogCambio extends Model
{
    protected $table='tbl_log_cambios';
    protected $guarded=[];
    public $timestamps = false;

    public static function insertarCambios($datos){
    	LogCambio::updateOrCreate(
    		['documento_id'=>$datos->documento_id,'campo'=>$datos->campo],
    		['documento_id'=>$datos->documento_id,
    		'campo'=>$datos->campo,
    		'val_original'=>$datos->val_original,
    		'val_cambio'=>$datos->val_cambio]);
    }
   
}
