<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VistaSat extends Model
{
    protected $table = 'vw_datos_catastrales';
    protected $primaryKey = 'clave';
    public $incrementing = false;
    
    public function titular(){
        return $this->belongsTo(Persona::class,'contribuyente','persona_id')
                  ->select('tipo_documento','numero_documento','cuit','nombre_completo','persona_id')
                ;
    }
}
