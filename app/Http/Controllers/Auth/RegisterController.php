<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Persona;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       // $this->middleware('guest');
//        $this->middleware('auth');
//        $this->middleware('roles:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
//                    '' => 'required|max:255',
//                    'email' => 'required|email|max:255|unique:users',
//                    'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $usuario = User::create([
                    'nom_usuario' => $data['nom_usuario'],
                    'cuit' => $data['cuit'],
                    'persona_id' => $data['persona_id'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);

        $usuario->roles()->attach($data['roles']);
        return $usuario;
    }

    public function getNyA($cuit) {
        return Persona::select('razon_social', 'apellido_y_nombre_padre', 'persona_id')
                        ->where('cuit', '=', "$cuit")
                        ->first();
    }

}
