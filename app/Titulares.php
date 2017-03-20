<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulares extends Model {

    protected $fillable = [
        "persona_id",
        "tipo",
        "doc_id"
    ];

    public function Personas() {
        return $this->hasOne(Persona::class, 'persona_id', 'persona_id');
    }

}
