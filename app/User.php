<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable {

    use Notifiable;
      protected $table='tbl_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_usuario', 'email','area_id','nombre'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    //protected $attributes = array('rol'=>'admin');


    public function roles() {
        return $this->belongsToMany(Role::class,'TBL_ROLE_USER');
    }

    public function hasRoles(array $roles) {

        return (bool) $this->roles->pluck('key')->intersect($roles)->count();
    }

    public function isAdmin() {
        return $this->hasRoles(['admin']);
    }

    public function isValidador() {
        return $this->hasRoles(['validador']);
    }
     public function isCorrector() {
        return $this->hasRoles(['corrector']);
    }
    
      public function isCarga() {
        return $this->hasRoles(['carga']);
    }
    
    public function area(){
        return $this->belongsTo(Area::class);
    }
    
    public function pedido(){
        return $this->hasMany(Pedido::class,'user_pedido_id','id');
    }

    public function notificaciones(){
        if($this->isCarga() || $this->isAdmin())
        {
            return Pedido::select('id')->where('terminado',false);
        }
        // retornar notificaciones.
    }


//    public static function listaUsuarios($rol) {
//        $users = User::where('id', '<>', auth()->user()->getAuthIdentifier());
//       // if (auth()->user()->isAdmin()) {
//            $users->whereHas('roles', function ($query) use ($rol) {
//                $query->where('roles.key', '=', 'jefe')
//                        ->orWhere('roles.key', '=', 'corrector');
//            });
////        } else {
////            $users->whereHas('roles', function ($query) use ($rol) {
////                $query->where('roles.key', '=', $rol);
////            })
////
////            ;
//       // }
//        return $users;
//    }

}
