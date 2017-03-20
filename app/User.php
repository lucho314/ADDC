<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_usuario', 'email', 'password', 'cuit', 'persona_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //protected $attributes = array('rol'=>'admin');


    public function roles() {
        return $this->belongsToMany(Role::class);
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
