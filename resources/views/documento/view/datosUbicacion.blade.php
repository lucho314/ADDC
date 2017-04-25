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
                            <input class="form-control" type="text" disabled   value="{{$documento->documentoSat[0]->datosSat->seccion}}"> </input>
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
                            <th class="col-xs-3"><div class='form-inline'><b>#</b> &nbsp; &nbsp;Plano</div></th>
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
                        <tr>
                            <td class="col-xs-3"><div class='form-inline'><b>{{$key}}</b> &nbsp; &nbsp;<input type="text" value="{{$documento->nro_plano}}" class="form-control" disabled></div></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->grupo}}" class="form-control" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->manzana}}" class="form-control"  disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->parcela}}" class="form-control" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->subparcela}}"  class="form-control" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->chacra}}" class="form-control" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->quinta}}" class="form-control" disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->lamina}}" class="form-control"  disabled></td>
                            <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->sublamina}}" class="form-control" disabled></td>
                            <th class="col-xs-1 text-center"></th>
                        <tr>
                            @endforeach
                    </tbody>
                </table>
                <div class="errores"></div>
            </div>
        </div>
    </div>
</div>
