<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model {

    protected $table = 'tbl_contenidos';
    protected $fillable = [
        'numero_desde',
        'numero_hasta',
        'caja_id',
    ];

    public static function boot() {
        parent::boot();

        static::saving(function($table) {
            $table->usuario_alta = auth()->user()->nom_usuario;
        });
    }

    public function caja() {
        return $this->belongsTo(Caja::class);
    }

    public static function buscar($dpto, $nro_plano, $tipo = null) {
         return Contenido::with('caja')
                ->whereHas('caja', function($query) use($dpto,$tipo) {
                    $query->where('dpto', '=', "$dpto");
                    $query->where('activo', '=','1');
                   if (!empty($tipo)) {
                        $query->where('tipo_doc', $tipo);
                    }
                })
                ->where('numero_desde', '<=', $nro_plano)
                ->where('numero_hasta', '>=', $nro_plano)
                ->first();
    }

    public function getDescUbicacionAttribute() {
        $des = 'SEC: ' . $this->caja->sector . ', MOD: ' . $this->caja->modulo . ', EST: ' . $this->caja->estante;
        return $des .= ', POS: ' . $this->caja->posicion . ", PROF: " . $this->caja->profundidad;
    }

}
