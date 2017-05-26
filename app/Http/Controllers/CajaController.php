<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use Yajra\Datatables\Facades\Datatables;
use DB;
use FPDI;
use Illuminate\Support\Facades\URL;

class CajaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('roles:validador,corrector,admin', ['only' => ['viewListaDocumentosPendientes', 'getListaDocumentosPendientes', 'validarDocumento', 'aceptarValidacion']]
        );
    }

    public function create(Request $dato) {
        $sectores = DB::table('tbl_sectores')->get();
        $departamentos = DB::table('vw_localidades')
                ->distinct()
                ->select('codigo_de', 'departamento', 'div_de')
                ->where('codigo_pr', '=', "08")
                ->orderBy('codigo_de')
                ->get();
        $min = $dato->min;
        return view('caja.create', compact('sectores', 'departamentos', 'min'));
    }

    public function store(Request $request) {
        $caja = Caja::create($request->all());
        $datos = $request->all();
        $datos['caja_id'] = $caja->id;
        \App\Contenido::create($datos);
        return redirect('caja/create');
    }

    public function getModulosXsector(Request $dato) {
        return \App\Modulo::disponibles($dato->sector);
    }

    public function getEstantesXmodulos(Request $dato) {
        $capacidad = $dato->capacidad / 8;
        $estantes = Caja::where('activo', '=', 0)
                ->where('modulo', '=', $dato->modulo)
                ->where('sector', '=', $dato->sector)
                ->first();
        if (count($estantes) == 0) {
            $estantes_disp = Caja::selectRaw('estante,max(posicion) as posicion')
                    ->where('modulo', '=', $dato->modulo)
                    ->where('sector', '=', $dato->sector)
                    ->groupBy('estante')
                    ->havingRaw("max(posicion)<$capacidad")
                    ->first();
            $estantes = Caja::where('sector', '=', $dato->sector)
                            ->where('modulo', '=', $dato->modulo)
                            ->where('estante', '=', $estantes_disp->estante)
                            ->where('posicion', '=', $estantes_disp->posicion)->get();
            if (count($estantes) > 1) {
                $estantes = Caja::buscarMayorNumeroCaja($estantes);
                $estantes->posicion++;
            } else {
                $estantes = $estantes[0];
            }
            $estantes->profundidad = ($estantes->profundidad == 1) ? 2 : 1;
        }

        return $estantes;
    }

    public function getNumeroCaja(Request $dato) {
        $caja = Caja::with('contenidos')
                ->where('tipo_doc', '=', 1)
                ->where('dpto', '=', $dato->dpto)
                ->whereIn('numero_caja', Caja::where('dpto', '=', $dato->dpto)
                        ->where('tipo_doc', '=', 1)->selectRaw('max(Numero_Caja)')
                        ->get()
                )
                ->first();
        return $caja->buscarUltimoRango();
    }

    public function imprimeEtiqueta(array $caja) {
        $pdf = new FPDI('P', 'mm', array(100, 150));
        $pdf->setSourceFile('../public/etiqueta.pdf');
        $tplIdx = $pdf->importPage(1);
        $pdf->AddPage();
        $i = 0;
        foreach ($caja as $c) {
            if ($i == 4) {
                $pdf->AddPage();
                $i = 0;
            }
            $datosCaja = Caja::with('contenidos')->find($c);
            Caja::formatearEtiqueta($pdf, $datosCaja, $tplIdx, $i);
            $i++;
        }
        $pdf->Output('D');
    }

    public function index() {
        $dptos = DB::table('vw_localidades')
                ->distinct()
                ->select('codigo_de', 'departamento', 'div_de')
                ->where('codigo_pr', '=', "08")
                ->orderBy('codigo_de')
                ->get();

        return view('caja/index', compact('dptos'));
    }

    public function listaCaja(Request $datos) {
        $caja = Caja::with('contenidos')->where('dpto', '=', $datos->dpto)->where('activo', '=', '1');
        $numero_hasta = $datos->numero_desde;
        if ($datos->numero_hasta != '') {
            $numero_hasta = $datos->numero_hasta;
        }
        $caja->whereHas('contenidos', function($query) use($datos, $numero_hasta) {
            $query->where('numero_desde', '<=', $numero_hasta);
            $query->where('numero_hasta', '>=', $datos->numero_desde);
        });
        return Datatables::eloquent($caja)
                        ->addColumn('accion', function ($caja) {
                            $accion = '<a href="javascript:eliminar_caja(' . $caja->id . ')" class="btn btn-xs btn-warning">Eliminar</a>&nbsp;&nbsp;';
                            return $accion .= '<a href="'.URL::action('CajaController@imprimirPendientes','id='.$caja->id).'" class="btn btn-xs btn-info">Imprimir etiqueta</a>';
                        })
                        ->editColumn('contenidos.numero_desde', function ($caja) {
                            return $caja->contenidos->pluck('numero_desde')->implode(' - ');
                        })
                        ->editColumn('contenidos.numero_hasta', function ($caja) {
                            return $caja->contenidos->pluck('numero_hasta')->implode(' - ');
                        })
                        ->editColumn('tipo_doc', function ($caja) {
                            return ($caja->tipo_doc == 2) ? 'Antecedente' : 'Tela';
                        })
                        ->make(true);
    }

    public function imprimirPendientes(Request $request) {
        if (!isset($request->id)) {
            $pendientes = Caja::where('completo', '=', 0)->where('activo', '=', '1')->pluck('id')->toArray();
            Caja::where('completo', '=', 0)->update(['completo' => '1']);
        }else{
            $pendientes=[$request->id];
        }
        $this->imprimeEtiqueta($pendientes);
    }

    public function eliminar(Request $request) {
        $caja = Caja::findOrFail($request->id);
        $caja->activo = '0';
        return ['Error' => $caja->save()];
    }

}
