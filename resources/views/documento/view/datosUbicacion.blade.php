<div class="container-fluid"> 
    <div class="col-md-4">
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Departamento</label>
                            <input type="text" class="form-control" disabled value="{{$ubicacionGeo->departamento}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distrito</label>
                            <input type="text" class="form-control" disabled value="{{$ubicacionGeo->distrito}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Localidad</label>
                            <input type="text" class="form-control" disabled value="{{$ubicacionGeo->localidad}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sección</label>
                            <input class="form-control" type="text" disabled   value="{{$vigente->$relacion->seccion}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Latitud (grados decimales):</label>
                            <input class="form-control" type="text" disabled> </input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Longitud (grados decimales):</label>
                            <input class="form-control" type="text" disabled> </input>
                        </div>
                    </div>
                    <div class="errores"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-border table-striped table-fixed">
                    <thead>
                        <tr>
                            <th class="col-xs-3">Plano</th>
                            <th class="col-xs-1 text-center">Grupo</th>
                            <th class="col-xs-1 text-center">Manzana</th>
                            <th class="col-xs-1 text-center">Parcela</th>
                            <th class="col-xs-1 text-center">Subparcela</th>
                            <th class="col-xs-1 text-center">Chacra</th>
                            <th class="col-xs-1 text-center">Quinta</th>
                            <th class="col-xs-1 text-center">Lamina</th>
                            <th class="col-xs-1 text-center">Sublamina</th>
                            <th class="col-xs-1 text-center"></th>

                        </tr>
                    </thead>
                   <tbody id="tabla_ubicacion">
                        @foreach($documento->documentoSat as $key=>$documento)
                        @if($documento->vigente)
                        <?php $relacion=$documento->getDatosRelacionados()?>
                        <tr>
                            <td class="col-xs-3"><input type="text" value="{{$documento->nro_plano}}" class="form-control" id="plano" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->grupo}}" class="form-control" id="lote_{{$key}}_grupo" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->manzana}}" class="form-control"  id="lote_{{$key}}_manzana" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->parcela}}" class="form-control"  id="lote_{{$key}}_parcela" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->subparcela}}"   class="form-control" id="lote_{{$key}}_subparcela" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->chacra}}" class="form-control"   id="lote_{{$key}}_chacra" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->quinta}}" class="form-control"    id="lote_{{$key}}_quinta" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->lamina}}" class="form-control" id="lote_{{$key}}_lamina" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->$relacion->sublamina}}" class="form-control"  id="lote_{{$key}}_sublamina" disabled></td>
                            <th class="col-xs-1 text-center"></th>
                        <tr>
                            @elseif(!is_null($documento->imponible_id))
                        <tr>
                            <td class="col-xs-3"><input type="text" value="{{$documento->nro_plano}}" class="form-control" id="lote_{{$key}}_nro_plano" disabled></td>
                            <td class="col-xs-9" colspan="9"><input class='form-control' type="text" disabled  value="PLANO NO VIGENTE"></td>
                        </tr>
                        @else
                            <tr>
                                <td class="col-xs-3"><input type="text" value="{{$documento->nro_plano}}" class="form-control" id="lote_{{$key}}_nro_plano" disabled></td>
                                <td class="col-xs-9" colspan="9"><input class='form-control' type="text" disabled  value="SIN DATOS"></td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="errores"></div>
            </div>
        </div>
    </div>
</div>
