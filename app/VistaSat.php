<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VistaSat extends Model
{
    protected $table = 'vw_datos_catastrales';
    protected $primaryKey = 'clave';
    public $incrementing = false;
    
}
