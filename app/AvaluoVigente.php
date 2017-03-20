<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvaluoVigente extends Model
{
    protected $table = 'vw_avaluo_vigente_inmuebles';
    protected $primaryKey = 'clave_imponible';
    public $timestamps = false;
   public $incrementing = false;
}
