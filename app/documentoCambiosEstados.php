<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class documentoCambiosEstados extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'doc_id',
        'estado_id',
        'user2_id',
        'descripcion'
    ];
    public $incrementing = false;

    public function getDates() {
        return array('fecha_cambio');
    }

    public function setDescripcionAttribute($value) {
        $this->attributes['descripcion'] = $value;
        if ($this->estado_id == '1') {
            $this->attributes['descripcion'] = 'Alta del documento';
        }
    }

    public static function boot() {
        parent::boot();
// create a event to happen on saving
        static::saving(function($table) {
            $table->user1_id = auth()->user()->nom_usuario;
            $table->fecha_cambio = Carbon::now();
        });
    }

    public function documento() {
        return $this->hasOne('App\Documento', 'documento_id', 'id');
    }

    public function Estado() {
        return $this->belongsTo('App\Estado', 'estado_id');
    }

}
