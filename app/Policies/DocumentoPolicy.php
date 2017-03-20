<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
     public function index(){
               
           return true;
    }
    
//    public function viewListaDocumentosPendientes(User $authUser){
//        if($authUser->hasRoles(['admin','corrector'])){
//            return true;
//        }
//        return false;
//    }
    
    
}
