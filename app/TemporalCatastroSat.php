<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporalCatastroSat extends Model {

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        "nro_dpto",
        "nro_partida",
        "nro_plano",
        "nro_matricula",
        "tipo_planta",
        "sup_terreno",
        "sup_edificada",
        "localidad",
        'distrito',
        "departamento",
        "inscripcion",
        "seccion",
        "grupo",
        "manzana",
        "parcela",
        "subparcela",
        "lamina",
        "sublamina",
        "usuario_alta",
        "imponible_id",
        "catastro_id",
        "doc_id",
        'agua',
        'gasoducto',
        'electroducto',
        'cloaca',
        'chacra',
        'quinta',
        'estado',
    ];

    public function update(array $attributes = [], array $options = []) {
        $this->fill($attributes);
        if ($this->estado == '1') {
            foreach ($this->getAttributes() as $key => $value) {
                $this->$key = str_replace("*", '', $value);
            }
        } else {
            foreach ($this->getDirty() as $key => $value) {
                $this->$key = $value . "*";
            }
        }
        parent::save();
    }

    public static function insertar(array $insert, $doc_id) {
        foreach ($insert['lote'] as $key => $val) {
            $insert['lote'][$key]['doc_id'] = $doc_id;
            TemporalCatastroSat::create(array_merge($insert['gral'], $insert['lote'][$key]));
        }
    }

    public static function editar(array $insert) {
        foreach ($insert['lote'] as $key => $val) {
            $insert['lote'][$key]['doc_id'] = $insert['gral']['id'];
            $lotes= TemporalCatastroSat::findOrFail($val['temporal_id']);
            $lotes->update(array_merge($insert['gral'], $insert['lote'][$key]));
        }
    }

    public static function boot() {
        parent::boot();
        // create a event to happen on updating
// create a event to happen on saving
        static::saving(function($table) {
            $table->usuario_alta = auth()->user()->nom_usuario;
            $table->agua = '0';
            $table->gasoducto = '0';
            $table->electroducto = '0';
            $table->cloaca = '0';
        });
    }

    public function Documento() {
        return $this->hasOne(Doc::class, 'id', 'doc_id');
    }

}
