<?php

//--------------------rutas de Usuarios-------------------------------------------------------------------------------------------

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('documento');
    }
    return view('auth/login');
});

Auth::routes();
Route::get('usuario/get_usuario_correo', 'UsuarioController@getUsuarioCorreo');
Route::get('/usuario_roles', 'UsuarioController@usuarioRoles');
Route::get('usuario/micuenta/{id}', 'UsuarioController@micuenta');
Route::get('usuario/edit/{id}', 'UsuarioController@edit');
Route::resource('usuario', 'UsuarioController');


//---------------------------------------------------------------------------------------------------------------------------------
//--------------------rutas de caja----------------------------------------------------------------------------------------------

Route::get('caja/eliminar', 'CajaController@eliminar');
Route::get('caja/imprimir_pendientes', 'CajaController@imprimirPendientes');
Route::get('caja/listar', 'CajaController@listaCaja');
Route::get('caja/imprime', 'CajaController@imprimeEtiqueta');
Route::get('caja/get_caja', 'CajaController@getNumeroCaja');
Route::get('caja/estantes_disponibles', 'CajaController@getEstantesXmodulos');
Route::get('caja/modulos_disponibles', 'CajaController@getModulosXsector');
Route::resource('caja', 'CajaController');
//---------------------------------------------------------------------------------------------------------------------------------
//--------------------rutas de Documentos-----------------------------------------------------------------------------------------

Route::get('documento/datos_certificado', 'DocumentoController@getDatosCertificado');
Route::get('documento/eliminar', 'DocumentoController@eliminar');
Route::get('documento/carga/lista/', 'DocumentoController@viewListaDocumentosCargados');
Route::get('documento/get_persona', 'DocumentoController@getPersona');
Route::get('documento/eliminar_registro', 'DocumentoController@eliminarRegistro');
Route::get('documento/prueba', 'DocumentoController@prueba');
Route::get('documento/titular', 'DocumentoController@getTitulares');
Route::get('documento/getDptos', 'DocumentoController@getDeptos');
Route::post('documento/validado', 'DocumentoController@aceptarValidacion')
        ->middleware('roles:validador,corrector,admin');
Route::post('documento/editado', 'DocumentoController@aceptarValidacion');
Route::get('documento/validar/getLista/', 'DocumentoController@getListaDocumentos');
Route::get('documento/validar/documento/{id}', 'DocumentoController@editarDocumento')->middleware('roles:validador,corrector,admin');
Route::get('documento/editar/{id}', 'DocumentoController@editarDocumento');
Route::get('documento/validar/lista/{mio}', 'DocumentoController@viewListaDocumentosPendientes');
Route::get('documento/compruebaPartidaRepetida/{n}/{p}', 'DocumentoController@compruebaPartidaRepetida');
Route::get('documento/checkDatosInex/{nro}/{i}/{f}', 'DocumentoController@checkDatosInex');
Route::get('documento/getDatos/', 'DocumentoController@getDatos');
Route::get('documento/checkPartida/', 'DocumentoController@checkPartida');
Route::get('documento/checkDuplicados/{dto}/{desde}/{hasta}', 'DocumentoController@checkDuplicados');
Route::get('documento/buscarFecha/', 'DocumentoController@buscarFecha');
Route::get('documento/buscarUbicacion/', 'DocumentoController@buscarUbicacion');
Route::get('documento/buscarMatricula/', 'DocumentoController@buscarMatricula');
Route::get('documento/buscarPlano/', 'DocumentoController@buscarPlano');
Route::get('documento/buscarPartida/', 'DocumentoController@buscarPartida');
Route::get('documento/buscarCertificado/', 'DocumentoController@buscarCertificado');
Route::get('documento/getUbicacion/{catastroId}', 'DocumentoController@getUbicacion');
Route::get('documento/getSuperficies/{imponibleId}', 'DocumentoController@getSuperficies');
Route::get('documento/view/{imponibleId}', 'DocumentoController@view');
Route::get('documento/cargarPlanosPartidas/{dpto}/{planoDesde}/{planohasta}', 'DocumentoController@cargarPlanosPartidas');
Route::get('documento/getLocalidades/{dto}', 'DocumentoController@getLocalidades');
Route::get('documento/getDtos/{dpto}', 'DocumentoController@getDtos');
Route::get('/gurdar_log', 'DocumentoController@insertarCambios');
Route::get('/get_documentos_cambio', 'DocumentoController@getCambios');
Route::get('documento/getResponsables/{id}', 'DocumentoController@getResponsables');
Route::get('/verificar_falta', 'DocumentoController@verificarFalta');
Route::get('/eliminar_log', function() {
    \App\LogCambio::whereRaw("REGEXP_LIKE (documento_id, '[^0-9]')")->delete();
});
Route::resource('documento', 'DocumentoController');
//---------------------------------------------------------------------------------------------------------------------------------

//--------------------rutas de Pedidos-----------------------------------------------------------------------------------------
Route::get('/pedido/terminados', 'PedidoController@viewTerminado');
Route::get('/pedido/listado_terminados', 'PedidoController@listadoTerminado');
Route::get('/pedido/listado_pendiente', 'PedidoController@listadoPendiente');
Route::get('/pedido/terminado', 'PedidoController@terminado');
Route::resource('pedido', 'PedidoController');


