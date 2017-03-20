<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imponible extends Model {

    protected $table = 'tbl_imponibles';
    protected $primaryKey = 'clave';
    public $timestamps = false;
    protected $fillatable = [
    ];
    public $incrementing = false;

    public function Catastro() {
        return $this->belongsTo('App\Catastro', 'catastro_id');
    }
    public function Persona() {
        return $this->belongsTo('App\Persona', 'contribuyente');
    }
    
    public function Documento(){
        return $this->hasOne('App\Documento','imponible_id','clave');
    }

        protected $guarded = [];

}
