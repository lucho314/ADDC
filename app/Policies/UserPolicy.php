<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
       return true;
    }
    
    public function before(User $user, $ability){
        if($user->isAdmin()){
            return true;
        }
    }


    public function editUpdate(User $authUser, User $usuario){
               
           return $authUser->id === $usuario->id;
    }
}
