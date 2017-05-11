<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Documento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use DB;
use App\Contenido;
use App\Http\Requests\DocumentoFormRequest;
use App\DocumentoSat;
use App\Antecedente;
use App\LogCambio;
use App\Objeto;
use App\Area;
use App\VistaSat;
use App\AvaluoHistorico;
use App\DocumentoEstado;

class DocumentoController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('roles:validador,corrector,admin', ['only' => ['viewListaDocumentosPendientes', 'validarDocumento', 'aceptarValidacion']]
        );
    }

    public function index() {
        $dptos = $this->getDeptos();
        return view('documento.index', compact('dptos'));
    }

    public function create() {
        $plantas = DB::table('tbl_valores_set_validaciones')->where('set_validacion', '=', '0054')->get();
        $objetos = Objeto::all();
        $dptos = $this->getDeptos();
        return view('documento.carga', ['min' => 'sidebar-collapse', 'plantas' => $plantas, 'objetos' => $objetos, 'dptos' => $dptos, 'documento' => []]);
    }

    public function store(DocumentoFormRequest $datos) {
        $doc = Documento::create($datos->gral);
        LogCambio::where('documento_id', $datos->_token)->update(['documento_id' => $doc->id]);
        if ($datos->estado === '6') {
            $this->cambiarEstado(6, $doc->id, null, 'Carga del documento en falta');
            return redirect('documento/create');
        }
        Antecedente::guardar($datos->plano_ant, $doc);
        $this->cambiarEstado(2, $doc->id, 'Carga del documento');
        DocumentoSat::insertar($datos->all(), $doc->id);

        return redirect('documento/create');
    }

    public function viewListaDocumentosPendientes($mio) {
        return view('documento.validar.lista', compact('mio'));
    }

    public function viewListaDocumentosCargados($mio = 1) {
        return view('documento.validar.lista', compact('mio'));
    }

    public function getListaDocumentos(Request $mio) {
        $documentos = Documento::getListaPendientes($mio->mio);
        return Datatables::eloquent($documentos)
                        ->addColumn('accion', function ($documentos) use($mio) {
                            return ($mio->mio) ? '<a href="/documento/view/' . $documentos->id . '" class="btn btn-xs btn-info"> Ver documento</a>'
                                    . '&nbsp;&nbsp; <a href="javascript:eliminar_carga(' . $documentos->id . ')" class="btn btn-xs btn-danger">Eliminar</a>' : '<a href="/documento/validar/documento/' . $documentos->id . '" class="btn btn-xs btn-warning"> Validar</a>';
                        })
                        ->editColumn('created_at', function ($documentos) {
                            return $documentos->created_at ? with(new Carbon($documentos->created_at))->format('d/m/Y') : '';
                        })
                        ->filterColumn('created_at', function($query, $keyword) {

                            $query->whereRaw("TO_CHAR(created_at, 'DD/MM/YYYY')  like ?", ["%$keyword%"]);
                        })
                        ->make(true);
    }

    public function validarDocumento($id) {
        $plantas = DB::table('tbl_valores_set_validaciones')->where('set_validacion', '=', '0054')->get();
        $objetos = Objeto::all();

        $documento = Documento::getDocumentForValidation($id)->findOrFail($id);
        $areas = Area::all();
        $incidencias = []; // \App\documentoCambiosEstados::where('doc_id', '=', $id)->orderBy('fecha_cambio', 'desc')->get();
        if ($documento->hasVigente()) {
            $vigente = $documento->primerImponible();
            $relacion = $vigente->getDatosRelacionados();
            $dtos = $this->getDtos($vigente->$relacion->departamento_id);
            $localidades = $this->getLocalidades($vigente->$relacion->distrito_id);
            $dptos = $this->getDeptos();
            if ($vigente->$relacion->tipo_planta_id > '0003') {
                $unidadMedida = 'Has';
            } else {
                $unidadMedida = 'm2';
            }
        }
        $min = 'sidebar-collapse';
        return view('documento.create', compact('documento', 'vigente', 'areas', 'objetos', 'plantas', 'min', 'unidadMedida', 'dptos', 'dtos', 'localidades', 'relacion', 'incidencias'));
    }

    public function aceptarValidacion(Request $datos) {
        $doc = Documento::findOrFail($datos->gral['id']);
        $doc->update($datos->gral);
        LogCambio::where('documento_id', $datos->_token)->update(['documento_id' => $doc->id]);
        Antecedente::Editar($doc, (empty($datos->plano_ant) ? [] : $datos->plano_ant));
        $this->cambiarEstado($datos->gral['estado_id'], $datos->gral['id'], $datos->gral['observacion'], $datos->area_id);
        return redirect('documento/validar/lista/0');
    }


    public function show($idImage) {
        $file = Documento::select('imagen', 'checksum', 'nombre')->findOrFail($idImage);
        if (md5($file->imagen) == $file->checksum) {
            $imagen = base64_decode($file->imagen);
            return Response::make($imagen, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => "inline;name='$file->nombre';filename='$file->nombre'"
            ]);
        } else {
            echo "error";
        }
    }

    public function view($idDocumento) {
        $plantas = DB::table('tbl_valores_set_validaciones')->where('set_validacion', '=', '0054')->get();
        $documento = Documento::with(['documentoSat.datosSat.titular', 'documentoSat.responsables.persona', 'documentoSat.responsables.tipoOcupacion', 'antecedentes', 'cambios', 'ultimoCambio', 'incidencias',])->findOrFail($idDocumento);
        if ($documento->estado == '6') {
            return view('documento.view');
        }
        $objetos = Objeto::all();
        if ($documento->hasVigente()) {
            $vigente = $documento->primerImponible();
            $relacion = $vigente->getDatosRelacionados();
            $ubicacionGeo = DB::table('Vw_Localidades')->where('div_lo', $vigente->$relacion->localidad_id)->first();
            if ($vigente->$relacion->tipo_planta_id > '0003') {
                $unidadMedida = 'Has';
            } else {
                $unidadMedida = 'm2';
            }
        }
        $precedentes=($documento->hasVigente())?[]: $this->returnVigente($documento);
        $ubicacionFisica = Contenido::buscar($documento->nro_dpto, $documento->documentoSat[0]->nro_plano, 2);
        $min = 'sidebar-collapse';
        return view('documento.view', compact('documento','precedentes', 'vigente', 'relacion', 'objetos', 'plantas', 'min', 'unidadMedida', 'ubicacionGeo', 'usuarios', 'incidencias', 'ubicacionFisica'));
    }

//########################### FUNCIONES GETTERS USADAS EN AJAX ##########################################   

    public function getDatos(Request $datos) {
        $problemas['inexistentes'] = [];
        $problemas['imponible_historico'] = [];
        $planos = VistaSat::where('dpto', '=', "$datos->dpto")
                ->whereRaw("cast(plano as integer) between " . $datos->get('plano') . " and " . $datos->get('plano_hasta'));


        $noEncontado = array_diff(range($datos->plano, $datos->plano_hasta), $planos->pluck('plano')->toArray());

        if (count($noEncontado) > '0') {
            $problemas = AvaluoHistorico::getImponibleHistoricoPlano($noEncontado, $datos->dpto);
        }
        $datos_mesa = []; //($datos->tipo_doc==1)? \App\Mesa_plano::get($datos->dpto, $datos->get('plano')):[];
        return ['existentes' => $planos->get(), 'inexistentes' => $problemas['inexistentes'], 'mesa' => $datos_mesa, 'imponible_historico' => $problemas['imponible_historico']];
    }
    

    public function getDeptos() {
        return DB::table('vw_localidades')
                        ->distinct()
                        ->select('codigo_de', 'departamento', 'div_de')
                        ->where('codigo_pr', '=', "08")
                        ->orderBy('codigo_de')
                        ->get();
    }

    public function getLocalidades($dto) {
        return DB::table('vw_localidades')
                        ->select('div_lo', 'localidad')
                        ->where('div_di', '=', "$dto")->get();
    }

    public function getDtos($dpto) {
        return DB::table('vw_localidades')
                        ->distinct()
                        ->select('distrito', 'div_di')
                        ->where('div_de', '=', "$dpto")->get();
    }


//############################# FUNCIONES DE BUSQUEDAS ###################################

    public function buscarPlano(Request $buscar) {
        $nroPlano = $buscar->get('nroPlano');
        $nroDpto = $buscar->get('nroDpto');

        $documentos = DocumentoSat::with(['documento.estado', 'documento.tipo', 'documento' => function($query) {
                        $query->select('tipo_doc_id', 'id', 'estado_id', 'fecha_registro');
                    }])->whereHas('documento', function($query) {
            $query->where('estado_id', '1');
        });

        if ($nroDpto !== '') {
            $documentos->where('nro_dpto', '=', $nroDpto);
        }
        $documentos->where('nro_plano', '=', $nroPlano);

        return $this->creaDatatableEloquentBusqueda($documentos, $nroPlano);
    }

    public function verificarFalta(Request $buscar) {
        $nroPlano = $buscar->get('nroPlano');
        $nroDpto = $buscar->get('nroDpto');
        $documento = Documento::where('estado_id', '6')
                ->where('nro_plano', '<=', $nroPlano)
                ->Where('nro_plano_hasta', '>=', $nroPlano);
        if ($nroDpto != '') {
            $documento->where('nro_dpto', $nroDpto);
        }
        return ['falta' => $documento->count()];
    }

    public function buscarPartida(Request $buscar) {
        $nroPartida = $buscar->get('nroPartida');
        $nroDpto = $buscar->get('nroDpto');

        $documentos = DocumentoSat::with(['documento.estado', 'documento.tipo', 'documento' => function($query) {
                        $query->select('tipo_doc_id', 'id', 'estado_id', 'fecha_registro');
                    }])->whereHas('documento', function($query) {
            $query->where('estado_id', '1');
        });


        if ($nroDpto !== '') {
            $documentos->where('nro_dpto', $nroDpto);
        }
        $documentos->where('nro_partida', $nroPartida);

        return $this->creaDatatableEloquentBusqueda($documentos);
    }

    public function buscarMatricula(Request $buscar) {
        $nroMatricula = $buscar->get('nroMatricula');
        $nroDpto = $buscar->get('nroDpto');

        $documentos = DocumentoSat::with(['documento.estado', 'documento.tipo', 'documento' => function($query) {
                        $query->select('tipo_doc_id', 'id', 'estado_id', 'fecha_registro');
                    }])->whereHas('documento', function($query) use ($nroMatricula, $nroDpto) {
            $query->where('estado_id', '1');
            if ($nroDpto != '') {
                $query->where('nro_dpto', $nroDpto);
            }
            $query->where('nro_matricula', $nroMatricula);
        }
        );
        return $this->creaDatatableEloquentBusqueda($documentos);
    }

    public function buscarCertificado(Request $buscar) {

        $nroCert = $buscar->get('nroCertificado');

        $documentos = DocumentoSat::with(['documento.estado', 'documento.tipo', 'documento' => function($query) {
                        $query->select('tipo_doc_id', 'id', 'estado_id', 'fecha_registro');
                    }])
                ->whereHas('documento', function($query) use ($nroCert) {
            $query->where('estado_id', '1');
            $query->where('certificado', $nroCert);
        });

        return $this->creaDatatableEloquentBusqueda($documentos);
    }

    public function buscarUbicacion(Request $buscar) {
        $todos = array_filter(array_slice($buscar->all(), 0, 7));
        $documentos = Documento::select('tipo_doc_id', 'documentos.id', 'estado_id', 'fecha_registro')
                ->with(['estado', 'tipo', 'documentoSat.datosSat'])
                ->where('estado_id', '1')
                ->whereHas('documentoSat.datosSat', function($query) use ($todos) {
            foreach ($todos as $key => $value) {
                $query->where("$key", "$value");
            }
        });
        return $this->creaDatatableEloquentBusqueda($documentos, false, 'fecha_registro');
    }


    private function creaDatatableEloquentBusqueda($documentos, $plano = false, $columFech = 'documento.fecha_registro') {
        $datatable = Datatables::eloquent($documentos)
                ->addColumn('accion', function ($documentos)use($plano) {
                    if (!isset($documentos->documento)) {
                        if ($documentos->estado == '6')
                            return '<a href="/documento/' . $documentos->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                        return '<a href="/documento/view/' . $documentos->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                    }
                    return '<a href="/documento/view/' . $documentos->documento->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                })
                ->editColumn($columFech, function ($documentos) use($columFech) {
            $instancia = (is_object($documentos->documento)) ? $documentos->documento : $documentos;
            $buscar = new Carbon($instancia->fecha_registro);
            return $buscar->format('d/m/Y');
        });
        if ($plano) {
            $datatable->editColumn('nro_plano', function ($documentos)use($plano) {
                return $documentos->nro_plano = $plano;
            });
        }
        $datatable->filterColumn('fecha_registro', function($query, $keyword) {

            $query->whereRaw("TO_CHAR(fecha_registro, 'DD/MM/YYYY')  like ?", ["%$keyword%"]);
        });

        return $datatable->make(true);
    }

//################################ validaciones #####################################################

    private function cambiarEstado($estado, $id, $descripcion, $area_id = null) {
        DocumentoEstado::create([
            'estado_id' => "$estado",
            'documento_id' => "$id",
            'descripcion' => "$descripcion",
            'area_id' => "$area_id"
        ]);
    }

    public function eliminar(Request $request) {
        if ($request->ajax()) {
            $documento = Documento::findOrFail($request->id);
            if ($documento->estado_id == 2) {
                return ['Error' => $documento->delete()];
            } else {
                return ['Error' => 0, 'mensaje' => 'El documento esta asignado a otro usuario, No se puede eliminar!'];
            }
        } else {
            abort(404);
        }
    }

    
    public function getDatosCertificado(Request $dato) {
        return \App\Mesa_ficha::get($dato->dpto, $dato->plano, $dato->certificado, $dato->fecha_registro);
    }

    
    public function insertarCambios(Request $datos) {
        LogCambio::insertarCambios($datos);
    }

    
    public function getCambios(Request $datos) {
        return LogCambio::where('documento_id', $datos->documento_id)->get();
    }

    public function returnVigente(Documento $doc) {
        return $vigente = Documento::with('documentoSat', 'tipo')
                        ->select('id', 'fecha_registro', 'tipo_doc_id')
                        ->whereHas('documentoSat', function($query) use ($doc) {
                            $query->where('imponible_id', $doc->documentoSat[0]->imponible_id)
                            ->where('vigente', 1);
                        })->get();
    }
    
    
    
    public function Prueba(Request $busqueda) {

        $doc = Documento::with('documentoSat')->find(15);
        return $this->comprobarVigente($doc);
    }

}
