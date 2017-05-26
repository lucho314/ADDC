<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\Http\Requests\PedidoFormRequest;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class PedidoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('pedido.listado_pendiente');
    }
    
    public function viewTerminado(){
        return view('pedido.listado_terminado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listadoPendiente() {
        $pendientes = Pedido::with('usuarioPidio')->terminado()->orderBy('fecha_pedido');
        return Datatables::eloquent($pendientes)
                        ->addColumn('acciones', function ($pendientes) {
                            return '<a href="#" title="Confirmar pedido"><i class="fa fa-check-square"></i></a>&nbsp;'
                                    . '<a href="#" title="Agregar detalle"><i class="fa fa-warning"></i></a>&nbsp;'
                                    . '<a href="#" title="Eliminar pedido"><i class="fa  fa-times-circle"></i></a>';
                        })
                        ->addColumn('desAv', function ($pendientes) {
                            return $pendientes->desc_avanzada;
                        })
                        ->editColumn('fecha_pedido', function ($pendientes) {
                            return $pendientes->fecha_pedido ? with(new Carbon($pendientes->fecha_pedido))->format('d/m/Y') : '';
                        })
                        ->make(true);
    }

    public function create() {
        return view('pedido.create');
    }

    public function listadoTerminado() {
        $pendientes = Pedido::with('usuarioPidio','usuarioAtendio')
                ->terminado(true)
                ->orderBy('fecha_terminado','desc');
        return Datatables::eloquent($pendientes)
                        ->editColumn('fecha_pedido', function ($pendientes) {
                            return $pendientes->fecha_pedido ? with(new Carbon($pendientes->fecha_pedido))->format('d/m/Y') : '';
                        })
                        ->editColumn('fecha_terminado', function ($pendientes) {
                            return $pendientes->fecha_terminado ? with(new Carbon($pendientes->fecha_terminado))->format('d/m/Y') : '';
                        })
                        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PedidoFormRequest $request) {
        if ($request->ajax()) {
            $pedido = new Pedido($request->all());
            return [
                'respuesta' => $pedido->usuarioPidio()->associate(auth()->user())
                        ->save()
                    ];
        }
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $pedido = Pedido::find($id);
        return ['respuesta' => $pedido->delete()];
    }

    public function terminado(Request $request) {
        $pedido = Pedido::find($request->id);
        $pedido->fill(array_merge($request->all(), ['terminado' => 1]));
        return ['respuesta' => $pedido->save()];
    }

}
