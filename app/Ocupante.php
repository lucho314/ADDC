<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupante extends Model {

    protected $table = 'tbl_ocupantes';
    protected $primaryKey = 'clave_imponible';
    public $timestamps = false;
    protected $fillatable = [
    ];
    protected $guarded = [];

     public function VistaDatos() {
        return $this->belongsTo('App\Persona', 'persona_id');
    }
}
