<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
   protected $table = 'tbl_personas';
    protected $primaryKey = 'persona_id';
    public $timestamps = false;
    protected $fillatable = [
    ];

    protected $guarded=[];
}
