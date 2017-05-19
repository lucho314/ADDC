<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoSat extends Model {

    protected $table='tbl_documento_sats';
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

    public function documento() {
        return $this->belongsTo(Documento::class);
    }

    public function getNroDptoAttribute($value) {
        return str_pad($value, 2, "0", STR_PAD_LEFT);
    }

    public function datosMensuraEspecial() {
        return $this->belongsTo(MensuraEspecial::class, 'mensura_especial_id');
    }

    public function responsables() {
        return $this->hasMany(Ocupante::class, 'clave_imponible', 'imponible_id');
    }

    public function getDatosRelacionados() {
        if (!is_null($this->imponible_id)) {
            return 'datosSat';
        } else if (!is_null($this->mensura_especial_id)) {
            return 'datosMensuraEspecial';
        }

        return false;
    }

    public static function insertar($datos, $docId) {
        if (isset($datos['lote'])) {
            foreach ($datos['lote'] as $key => $val) {
                $datos['lote'][$key]['documento_id'] = $docId;
                DocumentoSat::create(array_merge($datos['gral'], $datos['lote'][$key]));
            }
        }
        if (isset($datos['historico'])) {

            foreach ($datos['historico'] as $key => $val) {
                $datos['historico'][$key]['documento_id'] = $docId;
                DocumentoSat::create(array_merge($datos['gral'], $datos['historico'][$key]));
            }
        }
        if (isset($datos['inexistentes'])) {
            foreach ($datos['inexistentes'] as $key => $val) {
                $datos['inexistentes'][$key]['documento_id'] = $docId;
                DocumentoSat::create(array_merge($datos['gral'], $datos['inexistentes'][$key]));
            }
        }
        if (isset($datos['especial'])) {
            foreach ($datos['especial'] as $key => $val) {
                $mensuraEspecial = MensuraEspecial::create(array_merge($datos['gral'], $datos['especial'][$key]));
                $datos['especial'][$key]['documento_id'] = $docId;
                $datos['especial'][$key]['mensura_especial_id'] = $mensuraEspecial->id;
                DocumentoSat::create(array_merge($datos['gral'], $datos['especial'][$key]));
            }
        }
    }

}
