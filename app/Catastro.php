<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catastro extends Model {

    protected $table = 'tbl_catastros';
    protected $primaryKey = 'catastro_id';
    public $timestamps = false;
    protected $fillable = [
        'seccion',
        'grupo',
        'distrito',
        'localidad',
        'manzana',
        'parcela',
        'chacra',
        'quinta',
        'subparcela',
        'lamina',
        'sublamina',
        'gasoducto',
        'agua',
        'cloaca',
        'electroducto',
        'usuario_ult_mod',
        'fecha_ult_mod',
        'doc_id'
    ];
    

    public function Localidad() {
       
        return $this->belongsTo('App\Localidad', 'localidad','div_lo');
    }

    public function Documento(){
        return $this->hasone('App\Documento','catastro_id','catastro_id');
    }
    protected $guarded = [];
    
    
    

     public static function boot() {
        parent::boot();
        // create a event to happen on updating
        static::updating(function($table) {
            $table->usuario_ult_mod ='testing123'; //auth()->user()->nom_usuario;
            $table->fecha_ult_mod= \Carbon\Carbon::now();
        });

    }
}
