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
        'detalle_pedido',
        'tipo_doc'
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
    
    public function getDescAvanzadaAttribute(){
       
       $des="";
        
        $datos= VistaSat::with('Localidad','titular')->where('dpto', $this->nro_dpto)
                ->where('plano', $this->nro_plano)
                ->first();
        if(!empty($datos)){
           $des='DIS: '.$datos->localidad->distrito.", LOC: ".$datos->localidad->localidad.', SEC:'.$datos->seccion;
           $des.=', GPO:'.$datos->grupo.", MZA:".$datos->manzana." | TIT: ".$datos->titular->nombre_completo.' | ';
           $caja= Contenido::buscar($this->nro_dpto, $this->nro_plano);
           $des.=$caja->desc_ubicacion;
           
        }
        return $des;
    }
    
    
}
