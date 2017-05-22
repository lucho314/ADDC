<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
   protected $table='tbl_pedidos';
    public $timestamps =false;
    protected $fillable = [
        'nro_plano',
        'nro_dpto',
        'user_pedido_id',
        'fecha_pedido',
        'terminado',
        'fecha_terminado',
        'observaciones',
        'user_atendio_id',
        'detalle_pedido'
    ];
    
    
public static function boot() {
        parent::boot();
        static::creating(function($table) {
            $table->fecha_pedido = Carbon::now();
        });
}



     public function getDates() {
        return array('fecha_terminado', 'fecha_pedido');
    }

    public function usuarioPidio(){
        return $this->belongsTo(User::class,'user_pedido_id');
    }
    
    public function usuarioAtendio(){
        return $this->belongsTo(User::class,'user_atendio_id');
    }
}
