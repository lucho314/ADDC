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
        'vigente',
        'sup_titulo',
        'exceso'
    ];
    public $timestamps = false;

    public function datosSat() {
        return $this->hasOne(VistaSat::class, 'clave', 'imponible_id');
    }

    public function Documento() {
        return $this->belongsTo(Documento::class)->where('estado_id', '1');
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
        } else if (isset($datos['imponible'])) {
            $datos['gral']['documento_id'] = $docId;
            DocumentoSat::create(array_merge($datos['gral'], ['imponible_id' => $datos['imponible']]));
        } else if (isset($datos['especial'])) {
            foreach ($datos['especial'] as $key => $val) {
                $datos['especial'][$key]['departamento_id'] = $datos['departamento_id'];
                $datos['especial'][$key]['distrito_id'] = $datos['distrito_id'];
                $datos['especial'][$key]['localidad_id'] = $datos['localidad_id'];
                $datos['especial'][$key]['tipo_planta_id'] = $datos['tipo_planta_id'];
                $mensuraEspecial = MensuraEspecial::create($datos['especial'][$key]);
                $datos['especial'][$key]['documento_id'] = $docId;
                $datos['especial'][$key]['mensura_especial_id'] = $mensuraEspecial->id;
                DocumentoSat::create(array_merge($datos['gral'], $datos['especial'][$key]));
            }
        }
    }

}
