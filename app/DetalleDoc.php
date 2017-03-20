<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDoc extends Model {

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nro_plano',
        'nro_partida',
        'imponible_id',
        'catastro_id',
        'doc_id',
        'temporal_id'
    ];

   
    public function documento() {
        return $this->belongsTo('App\Doc', 'doc_id');
    }
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
            $table->estado='2';
        });
    }
    
      public function VistaDatos() {
       return $this->belongsTo('App\TemporalCatastroSat', 'temporal_id','id');
    }
    
 }
