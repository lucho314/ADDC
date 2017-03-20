<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class Documento extends Eloquent {

    protected $table = 'documento';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillatable = [
        'nro_dpto',
        'tipo_doc',
        'fecha_registro',
        'nro_plano',
        'nro_partida',
        'sup_mensura',
        'sup_titulo',
        'exeso',
        'imponible_id',
        'catastro_id',
        'imagen_id',
        'bis'
    ];

    public static function boot() {
        parent::boot();
        // create a event to happen on updating
        static::updating(function($table) {
            $table->usuario_ultima_mod = auth()->user()->nom_usuario;
        });

// create a event to happen on saving
        static::saving(function($table) {
            $table->usuario_alta = auth()->user()->nom_usuario;
            $table->usuario_ultima_mod = auth()->user()->nom_usuario;
        });
    }

    protected $guarded = [];

    public function getDates() {
        return array('created_at', 'updated_at', 'fecha_registro');
    }

    public function Catastro() {
        return $this->belongsTo('App\Catastro', 'catastro_id');
    }

    public function Imponible() {
        return $this->belongsTo('App\Imponible', 'imponible_id');
    }

    public function AvaluoVigente() {
        return $this->belongsTo('App\AvaluoVigente', 'imponible_id');
    }

    public function Imagen() {
        return $this->belongsTo('App\Imagen', 'imagen_id');
    }

    public function VistaDatos() {
        return $this->belongsTo('App\Vw_Partidas_Archivo', 'imponible_id');
    }

    public function Estado() {
        return $this->belongsTo('App\Estado', 'estado');
    }
    
    public function cambioEstado(){
        return $this->belongsToMany('App\documentoCambiosEstados','id','documento_id');
    }

}
