<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DocumentoEstado extends Model {

    protected $guarded = ['id'];
    public $timestamps = false;

    public function getDates() {
        return array('fecha');
    }

    public function setDescripcionAttribute($value) {
        $this->attributes['descripcion'] = $value;
        if ($this->estado_id == '1') {
            $this->attributes['descripcion'] = 'Alta del documento';
        }
    }
    
    public static function boot() {
        parent::boot();
        static::creating(function($table) {
            $table->nom_usuario = auth()->user()->nom_usuario;
            $table->fecha = Carbon::now();
        });
    }

}
