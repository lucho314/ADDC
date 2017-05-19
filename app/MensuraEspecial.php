<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensuraEspecial extends Model {

    protected $table='tbl_mensura_especials';
    protected $fillable = [
        'inscripcion',
        'tipo_planta_id',
        'sup_mensura',
        'sup_titulo',
        'exceso',
        'sup_edificada',
        'localidad_id',
        'distrito_id',
        'departamento_id',
        'seccion',
        'grupo',
        'manzana',
        'parcela',
        'subparcela',
        'lamina',
        'sublamina',
        'chacra',
        'quinta'
    ];
    public $timestamps = false;

}
