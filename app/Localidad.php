<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'vw_localidades';
    protected $primaryKey = 'codigo_lo';
    public $timestamps = false;
    protected $fillatable = [
    ];

    protected $guarded = [];
}
