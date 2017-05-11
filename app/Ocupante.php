<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupante extends Model {

    public $table = 'tbl_ocupantes';
    protected $primaryKey = 'clave_imponible';
    public $incrementing = false;

     public function getDates() {
        return array('fecha_ocupacion');
    }
    
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','persona_id')
                ->select('tipo_documento','numero_documento','cuit','nombre_completo','persona_id')
                ;
    }
    
    public function tipoOcupacion(){
        return $this->belongsTo(TipoOcupacion::class, 'tipo_ocupacion','tipo_ocupacion')
                ->select('tipo_ocupacion_descr as ocupacion');
    }
    
   
    
    
}
