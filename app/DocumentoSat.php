<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoSat extends Model {

    protected $fillable = [
        'documento_id',
        'imponible_id',
        'mensura_especial_id',
        'nro_plano',
        'nro_dpto',
        'nro_partida',
        'vigente'
    ];
    
      public $timestamps = false;

    public function datosSat() {
        return $this->hasOne(VistaSat::class, 'clave', 'imponible_id');
    }

    public function datosMensuraEspecial() {
        return $this->hasMany(VistaSat::class, 'mensura_especial_id', 'id');
    }

    public static function insertar($datos, $docId) {
        if (isset($datos['lote'])) {
            foreach ($datos['lote'] as $key => $val) {
                $datos['lote'][$key]['documento_id'] = $docId;
                DocumentoSat::create(array_merge($datos['gral'], $datos['lote'][$key]));
            }
        }
        else if(isset ($datos['imponible']))
        {
            $datos['gral']['documento_id']=$docId;
            DocumentoSat::create(array_merge($datos['gral'],['imponible_id'=>$datos['imponible']]));
        }
    }

}
