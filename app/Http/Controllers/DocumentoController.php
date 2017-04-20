<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Doc;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Vw_Partidas_Archivo;
use DB;
use App\Contenido;
use App\Http\Requests\DocumentoFormRequest;
use Adldap\Laravel\Facades\Adldap;

class DocumentoController extends Controller {

    public function __construct() {
//        $this->middleware('auth');
//        $this->middleware('roles:validador,corrector,admin', ['only' => ['viewListaDocumentosPendientes', 'validarDocumento', 'aceptarValidacion']]
  //      );
    }

    public function index() {

        $dptos = $this->getDeptos();
        return view('documento.index', compact('dptos'));
    }

    public function create() {
        $plantas = DB::table('tbl_valores_set_validaciones')->where('set_validacion', '=', '0054')->get();
        $objetos = \App\Objeto::all();
        $dptos = $this->getDeptos();
        return view('documento.carga', ['min' => 'sidebar-collapse', 'plantas' => $plantas, 'objetos' => $objetos, 'dptos' => $dptos, 'documento' => []]);
    }

    public function store(Request $datos) {
        //dd ($datos->all());
        $doc = \App\Documento::create($datos->gral);
        if ($datos->estado === '6') {
            $this->cambiarEstado(6, $doc->id, null, 'Carga del documento en falta');
            return redirect('documento/create');
       }
//       // \App\Antecedente::guardar($datos->plano_ant, $doc);
//      //  $this->cambiarEstado(2, $doc->id, null, 'Carga del documento');
       \App\DocumentoSat::insertar($datos->all(), $doc->id);

        return redirect('documento/create');
    }

    public function viewListaDocumentosPendientes($mio) {
        return view('documento.validar.lista', compact('mio'));
    }

    public function viewListaDocumentosCargados($mio = 1) {
        return view('documento.validar.lista', compact('mio'));
    }

    public function getListaDocumentos(Request $mio) {
        $documentos = \App\Documento::getListaPendientes($mio->mio);
        return Datatables::eloquent($documentos)
                        ->addColumn('accion', function ($documentos) {
                            return (auth()->user()->hasRoles(['carga'])) ? '<a href="/documento/view/' . $documentos->id . '" class="btn btn-xs btn-info"> Ver documento</a>'
                                    . '&nbsp;&nbsp; <a href="javascript:eliminar_carga(' . $documentos->id . ')" class="btn btn-xs btn-danger">Eliminar</a>' : '<a href="/documento/validar/documento/' . $documentos->id . '" class="btn btn-xs btn-warning"> Validar</a>';
                        })
                        ->editColumn('created_at', function ($documentos) {
                            return $documentos->created_at ? with(new Carbon($documentos->created_at))->format('d/m/Y') : '';
                        })
                        ->make(true);
    }

    public function validarDocumento($id) {
        $plantas = DB::table('tbl_valores_set_validaciones')->where('set_validacion', '=', '0054')->get();
        $objetos = \App\Objeto::all();
        $documento = \App\Documento::getDocumentForValidation($id)->findOrFail($id);
       /* if (auth()->user()->isCorrector() || auth()->user()->isAdmin()) {
            $documento->usuario_actual = auth()->user()->getAuthIdentifier();
            $documento->save();
        }*/
        $incidencias =[];// \App\documentoCambiosEstados::where('doc_id', '=', $id)->orderBy('fecha_cambio', 'desc')->get();
        //dd($documento->documentoSat[0]->datosSat);
        $dtos = $this->getDtos($documento->documentoSat[0]->datosSat->div_de);
        $localidades = $this->getLocalidades($documento->documentoSat[0]->datosSat->div_di);
        $dptos = $this->getDeptos();
        $min = 'sidebar-collapse';
        if ($documento->documentoSat[0]->datosSat->tipo_planta > '0003') {
            $unidadMedida = 'Has';
        } else {
            $unidadMedida = 'm2';
        }
        return view('documento.create', compact('documento', 'objetos', 'plantas', 'min', 'unidadMedida', 'dptos', 'dtos', 'localidades', /* 'usuarios', */ 'incidencias'));
    }

    public function aceptarValidacion(Request $datos) {
        $doc = Doc::findOrFail($datos->gral['id']);
        $doc->update($datos->gral);
        \App\Antecedente::Editar($doc, (empty($datos->plano_ant) ? [] : $datos->plano_ant));
        \App\TemporalCatastroSat::editar($datos->all());
        $this->cambiarEstado($datos->gral['estado'], $datos->gral['id'], $datos->user_derivar, $datos->gral['observacion']);
        return redirect('documento/validar/lista/0');
    }

//    private function storeValidado(Request $datos, $imagenId) {
//        $partidaPlano = array();
//        $partidasInex = (isset($datos->partidasInex)) ? $datos->partidasInex : [];
//        $partidasDup = (isset($datos->duplicados)) ? $datos->duplicados : [];
//        if (!empty($partidasDup) || !empty($partidasInex)) {
//            $partidaPlano = array_flip($partidasDup + $partidasInex); // los que tiene problemas.
//            $claves = $this->LoadDataFromImponible($partidasDup, $datos, true); // los datos del plano con partida duplicada def por el usuario.
//            $this->storageData($claves, $datos, $imagenId);
//            $this->storageData($partidasInex, $datos, $imagenId);
//        }
//        $claves = $this->LoadDataFromImponible($partidaPlano, $datos); //trae los datos de los planos sin problemas.
//        $this->storageData($claves, $datos, $imagenId);
//        return redirect('documento/validar/lista');
//    }

    /**
     * Carga desde la tabla Imponibles la clave imponible,
     * partida,numero de plano y catastro_id de uno o varios nuemeros de planos
     * correlativos.
     * @param array $pp posee el conjunto de planos que debe o no traer dependiendo la variable $ban
     * @param DocuementoFormRequest $datos Posee todos los datos ingresados por el usuario en el fomulario de carga   
     * @param boolean $ban indica si los datos del array $pp de deben traer o no de la DB.
     * @return array conjunto de claves imponibles,partidas,planos y catastro_id requeridos.
     */
    private function LoadDataFromImponible($pp, $datos, $ban = false) {
        $claves = Vw_Partidas_Archivo::select('clave', 'partida', 'plano', 'catastro_id')
                ->where('dpto', '=', $datos->get('nro_dpto'));
        if ($ban) {
            $claves->whereIn('partida', $pp);
        } else {
            $claves->whereRaw("cast(plano as integer) between " . $datos->get('nro_plano') . " and " . $datos->get('nro_plano_hasta'))
                    ->whereNotIn('plano', $pp);
        }

        return $claves->get();
    }

    /**
     * Verifica si en la DB (en la tabla tbl_imponibles) existen registros duplicados en un rango de planos de un Dpto.
     * @param Integer $dpto numero de departamento del rango a verificar,
     * @param Integer $desde posee un numero de plano desde el cual partir en la busqueda.
     * @param Integer $hasta posee un numero de plano hasta el cual realizar la busqueda.
     * @return array de planos que se repiten mas de una vez y cantidad de veces que se repiten .
     * */
    public function checkDuplicados($dpto, $desde, $hasta) {
        $duplicados = Vw_Partidas_Archivo::select('plano')
                ->where('dpto', '=', $dpto)
                ->whereRaw("TO_NUMBER(plano) between $desde and $hasta")
                ->havingRaw('count(plano) >1')
                ->groupBy('plano')
                ->get();
        foreach ($duplicados as $dup) {
            $planosDup[] = $dup->plano;
        }
        return (isset($planosDup)) ? $planosDup : [];
    }

    /**
     * Verifica que el par plano-partida ingresados por el usuario se corresponden en la DB.
     * @param Request $datos posee los datos ingresados en el formulario de carga,(conjunto plano-partida y nro Dpto)
     * @return array pares de partida-planos que no verifican la correspondencia en la DB.
     * */
    public function checkPartida(Request $datos) {
        $partidas = $datos->partidasDup;
        $dpto = $datos->nroDpto;
        $planos = array_flip($partidas);
        $cantidadDatos = count($partidas);
        $cantidadVeridicados = DB::table('tbl_imponibles')
                        ->where('col01', '=', $dpto)
                        ->whereIn('col29', $planos)
                        ->whereIn('col02', $partidas)->get();

        if ($cantidadDatos === $cantidadVeridicados->count()) {
            return 0;
        } else {
            $plano = array();
            foreach ($cantidadVeridicados as $value) {
                $plano[] = $value->col29;
            }
            return (array_diff($planos, $plano));
        }
    }

    public function checkDatosInex($dpto, $desde, $hasta) {
        $listaTotalPlanos = range($desde, $hasta);
        $duplicados = $this->checkDuplicados($dpto, $desde, $hasta);
        $planos = array_flip($listaTotalPlanos);
        $planos = array_fill($desde, count($planos), '');
        $registros = Vw_Partidas_Archivo::select('partida', 'plano')
                ->where('dpto', '=', $dpto)
                ->whereRaw("cast(plano as integer) between $desde and $hasta")
                ->whereNotIn('plano', $duplicados)
                ->orderBy('plano')
                ->get();
        foreach ($registros as $obj) {
            $planos[$obj->plano] = $obj->partida; //agregar index plano
        }
        $respuesta['planoDup'] = [];
        foreach ($duplicados as $dup) {
            $respuesta['planoDup'][$dup] = $this->getPartidasByPlanos($dup, $dpto);
            unset($planos[$dup]);
        }
        $respuesta['plano'] = $planos;
        return $respuesta;
    }

    /**
     * Graba en la DB los datos de un documento.
     * @param array $claves contiene conjuntos de partidas,planos,clave_imponible y catastro_id a insertar
     * @param Request $datos contiene los datos obtenidos del formulario de carga.
     * @param integer $imagenId codigo de la imagen al que pertenecen los datos.
     *       */
//    private function storageData($datos, $imagenId) {
//
//        foreach ($datos as $plano => $partida) {
//            $documento = new DetalleDoc();
//            $documento->nro_partida = $partida;
//            $documento->nro_plano = $plano;
//            $documento->imponible_id = $datos->imponible_id[$plano];
//            $documento->catastro_id = $datos->catastro_id[$plano];
//            $documento->estado = $datos->estado;
//            $documento->doc_id = $imagenId;
//            $documento->save();
//        }
//    }

    public function show($idImage) {
        $file = \App\Documento::select('imagen', 'checksum','nombre')->findOrFail($idImage);
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
        $documento = Doc::with(['temporal', 'antecedentes'])->findOrFail($idDocumento);
        if ($documento->estado == '6') {
            return view('documento.view');
        }
        $objetos = \App\Doc_objeto::all();
        $incidencias = \App\documentoCambiosEstados::where('doc_id', '=', $idDocumento)->orderBy('fecha_cambio', 'desc')->get();
        $dtos = $this->getDtos($documento->temporal[0]->departamento);
        $localidades = $this->getLocalidades($documento->temporal[0]->distrito);
        $dptos = $this->getDeptos();
        $ubicacionFisica = Contenido::buscar($documento->nro_dpto, $documento->temporal[0]->nro_plano, 2);
        $min = 'sidebar-collapse';
        if ($documento->temporal[0]->tipo_planta > '0003') {
            $unidadMedida = 'Has';
        } else {
            $unidadMedida = 'm2';
        }
        return view('documento.view', compact('documento', 'objetos', 'plantas', 'min', 'unidadMedida', 'dptos', 'dtos', 'localidades', 'usuarios', 'incidencias', 'ubicacionFisica'));
    }

//########################### FUNCIONES GETTERS USADAS EN AJAX ##########################################   

    public function getResponsables($claveImponible) {
        $ocupantes = DB::table('tbl_ocupantes')
                ->leftJoin('tbl_personas', 'tbl_personas.persona_id', '=', 'tbl_ocupantes.persona_id')
                ->select(['tbl_personas.cuit', 'tbl_personas.nombre_completo', 'fecha_ocupacion'])
                ->where('clave_imponible', '=', $claveImponible);
        return Datatables::of($ocupantes)
                        ->editColumn('fecha_ocupacion', function ($ocupantes) {
                            return $ocupantes->fecha_ocupacion ? with(new Carbon($ocupantes->fecha_ocupacion))->format('d/m/Y') : '';
                        })
                        ->filterColumn('cuit', function($query, $keyword) {
                            $query->whereRaw("TBL_PERSONAS.cuit like ?", ["%{$keyword}%"]);
                        })
                        ->filterColumn('nombre_completo', function($query, $keyword) {
                            $a = strtoupper($keyword);
                            $query->whereRaw("UPPER(TBL_PERSONAS.nombre_completo) like ?", ["%{$a}%"]);
                        })
                        ->make(true);
    }

    public function getDatos(Request $datos) {
       $imponible_historico='';
        $planos = \App\VistaSat::where('dpto', '=', "$datos->dpto")
                ->whereRaw("cast(plano as integer) between " . $datos->get('plano') . " and " . $datos->get('plano_hasta'));
     if($planos->count()=='0'){
         $imponible_historico=\App\AvaluoHistorico::getImponibleHistoricoPlano($datos->plano, $datos->dpto);
      }     
        $ubicacionFisica =[];// \App\Contenido::buscar($datos->dpto, $datos->get('plano'));
        $datos_mesa = [];//($datos->tipo_doc=='plano')? \App\Mesa_plano::get($datos->dpto, $datos->get('plano')):[];
        $totalPlano = array_flip(range($datos->plano, $datos->plano_hasta));
        foreach ($planos as $plano) {
            unset($totalPlano[$plano->plano]);
        }
        return ['existentes' => $planos ->get(), 'inexistentes' => array_flip($totalPlano), 'ubicacionFisica' => $ubicacionFisica,'mesa'=>$datos_mesa,'imponible_historico'=>$imponible_historico];
    }

//Select Departamento,codigo_de From Vw_Localidades where Codigo_Pr ='08'  Group by Departamento,codigo_de order by Codigo_De
    public function getDeptos() {
        return DB::table('vw_localidades')
                        ->distinct()
                        ->select('codigo_de', 'departamento', 'div_de')
                        ->where('codigo_pr', '=', "08")
                        ->orderBy('codigo_de')
                        ->get();
    }

    public function getLocalidades($dto) {
        return DB::table('vw_localidades')->where('div_di', '=', "$dto")->get();
    }

    public function getDtos($dpto) {
        return DB::table('vw_localidades')
                        ->distinct()
                        ->select('distrito', 'div_di')
                        ->where('div_de', '=', "$dpto")->get();
    }

    private function getPartidasByPlanos($plano, $dpto) {
        $partidas = Vw_Partidas_Archivo::select('partida')
                ->where('dpto', '=', "$dpto")
                ->where('plano', '=', "$plano")
                ->get();
        foreach ($partidas as $par) {
            $partida[] = $par->partida;
        }
        return $partida;
    }

//############################# FUNCIONES DE BUSQUEDAS ###################################

    public function buscarPlano(Request $buscar) {
        $nroPlano = $buscar->get('nroPlano');
        $nroDpto = $buscar->get('nroDpto');
        $documentos = Doc::with(['temporal', 'estado','tipo']);
             if ($nroDpto!==''){
                $documentos->where('nro_dpto', '=', $nroDpto);
             }
                $documentos->where('nro_plano', '<=', $nroPlano)
                            ->where('nro_plano_hasta', '>=', $nroPlano)
                            ->with(['temporal' => function($query)use($nroPlano) {
                                    $query->where('nro_plano', '=', $nroPlano);
                                }]);

        return $this->creaDatatableEloquentBusqueda($documentos, $nroPlano);
    }

    public function buscarPartida(Request $buscar) {
        $nroPartida = $buscar->get('nroPartida');
        $nroDpto = $buscar->get('nroDpto');
        $documentos = \App\TemporalCatastroSat::with('documento.estado','documento.tipo');
//                ->select(['temporal_catastro_sats.*', 'docs.tipo_doc', 'docs.fecha_registro'])
                if ($nroDpto!==''){
                    $documentos->where('temporal_catastro_sats.nro_dpto', "=", $nroDpto);
                }
                    $documentos->where('temporal_catastro_sats.nro_partida', "=", $nroPartida)
                            ->where('temporal_catastro_sats.estado', '=', 1);
       // dd($documentos);
        return $this->creaDatatableEloquentBusqueda($documentos);
    }

    public function buscarMatricula(Request $buscar) {
        $nroMatricula = $buscar->get('nroMatricula');
        $nroDpto = $buscar->get('nroDpto');
        $documentos = \App\TemporalCatastroSat::with(['documento.estado','documento.tipo'])
               ->select(['temporal_catastro_sats.*'])
                ->where('temporal_catastro_sats.nro_dpto', "=", $nroDpto)
                ->where('temporal_catastro_sats.nro_matricula', "=", $nroMatricula)
                ->where('temporal_catastro_sats.estado', '=', 1);

        return $this->creaDatatableEloquentBusqueda($documentos);
    }

    public function buscarCertificado(Request $buscar) {

        $nroCert = $buscar->get('nroCertificado');

        $documentos = Doc::with('temporal','estado','tipo')
                    ->where('certificado','=', $nroCert);

        return $this->creaDatatableEloquentBusqueda($documentos);
    }
    
    public function buscarUbicacion(Request $buscar) {
         $todos = array_filter(array_slice($buscar->all(), 0, 7));
//unset($todos['departamento'], $todos['start'], $todos['columns'], $todos['search'], $todos['length'], $todos['order'], $todos['_'], $todos['draw']);
        $documentos = \App\TemporalCatastroSat::with('documento.estado','documento.tipo')
                ->select('temporal_catastro_sats.*');
        /* $documentos = DB::table('tbl_catastros')
          ->join('documento', 'documento.catastro_id', '=', 'tbl_catastros.catastro_id')
          ->select(['documento.id', 'documento.tipo_doc', 'documento.nro_dpto', 'documento.nro_plano', 'documento.nro_partida', 'documento.fecha_registro']);
         */
        foreach ($todos as $key => $value) {
            $documentos->where("$key", '=', "$value");
        }
        return $this->creaDatatableEloquentBusqueda($documentos);
    }

    public function buscarFecha(Request $buscar) {
        $todos = array_filter(array_slice($buscar->all(), 0,2));
        $documentos = Doc::with('temporal','estado','tipo');
        foreach ($todos as $key => $value) {
            $documentos->where("$key", '=', "$value");
        }
        return $this->creaDatatableEloquentBusqueda($documentos);
     }

    private function creaDatatableEloquentBusqueda($documentos, $plano = false) {
        $datatable = Datatables::eloquent($documentos)  
                
                ->addColumn('accion', function ($documentos)use($plano) {
                    if (!isset($documentos->documento)) {
                        if ($documentos->estado == '6')
                            return '<a href="/documento/' . $documentos->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                        return '<a href="/documento/view/' . $documentos->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                    }
                    return '<a href="/documento/view/' . $documentos->documento->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                })
                ->editColumn('fecha_registro', function ($documentos) {
                    return $documentos->fecha_registro ? with(new Carbon($documentos->fecha_registro))->format('d/m/Y') : '';
                });
        if ($plano) {
            $datatable->editColumn('nro_plano', function ($documentos)use($plano) {
                return $documentos->nro_plano = $plano;
            });
        }
        $datatable ->filterColumn('fecha_registro', function($query, $keyword) {
                            
                             $query->whereRaw("TO_CHAR(fecha_registro, 'DD/MM/YYYY')  like ?", ["%$keyword%"]);

                        });
        
        return $datatable->make(true);
    }

    private function creaDatatableQueryBuilderBusqueda($documentos) {
        return Datatables::of($documentos)
                        ->addColumn('accion', function ($documentos) {
                            return '<a href="/documento/view/' . $documentos->id . '" target="_blank" class="btn btn-xs btn-info"> Ver imagen</a>';
                        })
                        ->editColumn('fecha_registro', function ($documentos) {
                            return $documentos->fecha_registro ? with(new Carbon($documentos->fecha_registro))->format('d/m/Y') : '';
                        })
                        ->filterColumn('nro_plano', function($query, $keyword) {
                            $query->whereRaw("documento.nro_plano like ?", ["%{$keyword}%"]);
                        })
                        ->filterColumn('nro_partida', function($query, $keyword) {
                            $query->whereRaw("documento.nro_partida like ?", ["%{$keyword}%"]);
                        })
                        ->filterColumn('tipo_doc', function($query, $keyword) {
                            $a = strtoupper($keyword);
                            $query->whereRaw("UPPER(documento.tipo_doc) like ?", ["%{$a}%"]);
                        })
                        
                        ->make(true);
    }

    public function actualizaTemporalCastros(Request $datos, $documento) {
        $datos = $datos->all();
        $datos['nro_partida'] = $documento->nro_partida;
        $datos['nro_plano'] = $documento->nro_plano;
        $datos['imponible_id'] = $documento->imponible_id;
        $datos['catastro_id'] = $documento->catastro_id;
        // dd($datos);
        \App\TemporalCatastroSat::create($datos);
    }

//################################ validaciones #####################################################

    function compruebaPartidaRepetida($dpto, $partida) {
        return Vw_Partidas_Archivo::where('dpto', '=', "$dpto")
                        ->where('partida', '=', "$partida")
                        ->count();
    }

    private function cambiarEstado($estado, $id, $usr2 = null, $descripcion = null) {
        $cambioEstado = new \App\documentoCambiosEstados;
        $cambioEstado->estado_id = $estado;
        $cambioEstado->user2_id = $usr2;
        $cambioEstado->descripcion = $descripcion;
        $cambioEstado->doc_id = $id;
        $cambioEstado->save();
    }

    public function getTitulares() {
        return \App\Titulares::with('personas')->get();
    }

    public function Prueba(Request $busqueda) {
//         $username='IC21512680';
//          $password='ic21512680';
//         dd(Adldap::auth()->attempt($username, $password)); 
        if ($busqueda->q === 'p') {
           return DB::conetion('theclip')->table('acajas')->all();
        } else {
            phpinfo();
        }
//         $a=  Adldap::search()->Where('sn','=','carrero')/*
//                            ->orWhere('description','=','Catastro')*/
////                 ->orWhere('givenname', '=', "$busqueda->q")
////                              ->orWhere('cn','=',"$busqueda->q")
//                               ->get();
    // dd($a);
//    foreach($a as $usr){
//        echo "------------------------------------------------------------";
//        
//        foreach ($usr->getAttributes() as $atr=>$value){
//           
//                   echo  $atr.":".$value[0]."<br>";
//        }
//        echo "------------------------------------------------------------";
//    }
   
   
      phpinfo();
        
    }

    public function eliminarRegistro(Request $dato) {
        $temporal = \App\TemporalCatastroSat::findOrFail($dato->id);
        $cantidad = DB::table('temporal_catastro_sats')->where('doc_id', '=', $temporal->doc_id)->count();
        if ($cantidad > 1) {
            return ['Error' => \App\TemporalCatastroSat::destroy($dato->id), 'mensaje' => 'Se produjo un error al eliminar el registro'];
        } else {
            return ['Error' => 0, 'mensaje' => 'Unico registro, no se puede eliminar'];
        }
    }

    public function getPersona(Request $d) {
        return \App\Persona::select('nombre_completo')
                        ->where('numero_documento', '=', $d->dni)
                        ->orWhere('cuit', '=', $d->dni)
                        ->firstOrFail();
    }

    public function eliminar(Request $request) {
        if ($request->ajax()) {
            $documento = Doc::findOrFail($request->id);
            if ($documento->estado == 2) {
                \App\TemporalCatastroSat::where('doc_id', '=', $request->id)->delete();
                \App\documentoCambiosEstados::where('doc_id', '=', $request->id)->delete();
                return ['Error' => $documento->delete()];
            } else {
                return ['Error' => 0, 'mensaje' => 'El documento esta asignado a otro usuario, No se puede eliminar!'];
            }
        } else {
            abort(404);
        }
    }

    
    public function getDatosCertificado(Request $dato){
        return \App\Mesa_ficha::get($dato->dpto, $dato->plano,$dato->certificado,$dato->fecha_registro);
    }
    
    public function insertarCambios(Request $datos){
        \App\LogCambio::insertarCambios($datos);
    }
}
