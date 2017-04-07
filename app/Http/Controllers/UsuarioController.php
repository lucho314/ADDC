<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\usuarioFormRequest;
use Adldap\Laravel\Facades\Adldap;
use App\Role;

class UsuarioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('roles:admin', ['except' => ['edit', 'update']]);
    }

    public function index() {
        $usuarios = User::all();
        return view('usuario/index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::pluck('nombre', 'id');
        $usuarios = Adldap::search()->select('displayname', 'cn')//findByDnOrFail("CN=CA12134597,CN=Users,DC=dgr-er,DC=gov,DC=ar");
                        ->Where('description','contains','catastro')->get();
                       
        return view('auth/register', compact('usuarios','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        return User::with('Roles')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $usuario = User::with('Roles')->findOrFail($id);

        $this->authorize('editUpdate', $usuario);

        $roles = \App\Role::pluck('nombre', 'id');
        return view('usuario.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(usuarioFormRequest $request, $id) {
        $usuario = User::findOrFail($id);
        $this->authorize('editUpdate', $usuario);
        $usuario->update($request->all());
        if (auth()->user()->isAdmin()) {
            $usuario->roles()->sync($request->roles);
        }
        return redirect('usuario');
    }

    public function micuenta($id) {
        $usuario = User::findOrFail($id);
        return view('usuario.micuenta', compact('usuario'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
    
    public function getUsuarioCorreo(Request $dato){
        return  Adldap::search()->select('cn','mail')->findByDnOrFail($dato->dn);
        
    }
}
