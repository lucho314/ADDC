<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model {

    protected $table = 'tbl_pedidos';
    public $timestamps = false;
    protected $fillable = [
        'nro_plano',
        'nro_dpto',
        'USER_PEDIDO_ID',
        'fecha_pedido',
        'terminado',
        'fecha_terminado',
        'observaciones',
        'user_atendio_id',
        'detalle_pedido',
        'tipo_doc'
    ];

    public static function boot() {
        parent::boot();
        static::creating(function($table) {
            $table->fecha_pedido = Carbon::now();
            $table->USER_PEDIDO_ID = (string) auth()->user()->id;
        });

        static::updating(function($table) {
            $table->fecha_terminado = Carbon::now();
            $table->user_atendio_id = (string) auth()->user()->id;
        });
    }

    public function setObservacionesAttribute($value) {
        $this->attributes['observaciones'] = $value;
        if ($value === '') {
            $this->attributes['observaciones'] = 'La documentación solicitada fue encontrada';
        }
    }

    public function getDates() {
        return array('fecha_terminado', 'fecha_pedido');
    }

    public function usuarioPidio() {
        return $this->belongsTo(User::class, 'user_pedido_id');
    }

    public function usuarioAtendio() {
        return $this->belongsTo(User::class, 'user_atendio_id');
    }

    public function getDescAvanzadaAttribute() {

        $this->nro_dpto = \str_pad($this->nro_dpto, 2, "0", STR_PAD_LEFT);

        $des = "";

        $datos = VistaSat::with('Localidad', 'titular')->where('dpto', $this->nro_dpto)
                ->where('plano', $this->nro_plano)
                ->first();
        if (!empty($datos)) {
            $des = 'DIS: ' . $datos->localidad->distrito . ", LOC: " . $datos->localidad->localidad . ', SEC:' . $datos->seccion;
            $des .= ', GPO:' . $datos->grupo . ", MZA:" . $datos->manzana . " | TIT: " . $datos->titular->nombre_completo;
            $fecha_alta = AvaluoHistorico::getFechaUltimaTranferencia($datos->clave);

            if (!is_null($fecha_alta)) {
                $des .= " FT:" . $fecha_alta->fecha_alta->format('d/m/Y');
            }

            $des .= '| ';
        }
        $tipo = ($this->tipo_doc == 3) ? 1 : $this->tipo_doc;
        $caja = Contenido::buscar($this->nro_dpto, $this->nro_plano, $tipo);
        $des .= (!empty($caja)) ? $caja->desc_ubicacion : '';
        return $des;
    }

    public function scopeTerminado($query, $terminado = false) {
        return $query->where('terminado', $terminado);
    }

}
