<?php

namespace App;
use Image;

use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Eloquent\OracleEloquent  as Eloquent;

class Imagen extends Eloquent
{
    
   protected $table = 'imagen';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillatable = [
        'checksum',
        'nombre'
    ];
    public function documento(){
        return $this->hasMany('App\Documento');
    }
    protected $binaries = ['imagen'];
    protected $guarded=[];   
    
}