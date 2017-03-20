<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\usuarioFormRequest;
use App\Persona;

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
        //
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
        if(auth()->user()->isAdmin()) {
            $usuario->roles()->sync($request->roles);
        }
        return redirect('usuario');
    }

    public function micuenta($id){
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
   

}
