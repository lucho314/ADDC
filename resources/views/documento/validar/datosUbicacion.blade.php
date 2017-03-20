<div class="container-fluid"> 
    <div class="col-md-4">
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Departamento</label>
                            @if(strpos($documento->temporal[0]->departamento, '*'))

                            <select  id="departamento" class="form-control select-modificar sistema" style="border: solid 1px blue" readonly>
                                @else
                                <select  id="departamento" class="form-control select-modificar sistema" readonly>
                                    @endif
                                    @foreach($dptos as $dpto) 
                                    <option value="{{$dpto->div_de}}" 
                                            <?= ($dpto->div_de == str_replace('*', '', $documento->temporal[0]->departamento)) ? 'selected' : '' ?>>{{$dpto->departamento}} 
                                    </option>
                                    @endforeach
                                </select> 
                                <input type="hidden" name="departamento" id="departamento_input" value="{{$documento->temporal[0]->departamento}}">
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Distrito</label>
                                        @if(strpos($documento->temporal[0]->distrito, '*'))
                                        <select  id="distrito" readonly class="form-control select-modificar sistema" style="border: solid 1px blue">
                                            @else
                                            <select id="distrito" readonly class="form-control select-modificar sistema">
                                                @endif
                                                @foreach($dtos as $dto) 
                                                <option value="{{$dto->div_di}}" 
                                                        <?= ($dto->div_di == str_replace('*', '', $documento->temporal[0]->distrito)) ? 'selected' : '' ?>>{{$dto->distrito}} 
                                                </option>
                                                @endforeach
                                            </select> 
                                            <input type="hidden" name="distrito" id="distrito_input" value="{{$documento->temporal[0]->distrito}}">
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Localidad</label>
                                                    @if(strpos($documento->temporal[0]->localidad, '*'))

                                                    <select  id="localidad" readonly class="form-control select-modificar sistema" style="border: solid 1px blue">
                                                        @else

                                                        <select  readonly id="localidad" class="form-control select-modificar sistema">
                                                            @endif
                                                            @foreach($localidades as $loc) 
                                                            <option value="{{$loc->div_lo}}" 
                                                                    <?= ($loc->div_lo == str_replace('*', '', $documento->temporal[0]->localidad)) ? 'selected' : '' ?>>{{$loc->localidad}} 
                                                            </option>
                                                            @endforeach
                                                        </select> 
                                                        <input type="hidden" name="localidad" id="localidad_input" value="{{$documento->temporal[0]->localidad}}">
                                                        </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Sección</label>
                                                                <input class="form-control modificar sistema" type="text" readonly name="seccion" id="seccion" value="{{$documento->temporal[0]->seccion or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Latitud (grados decimales):</label>
                                                                <input class="form-control sistema" type="text"  name="latitud" id="latitud" value="{{$documento->latitud or old('latitud')}}" placeholder=" ej: Paraná= -31.73197"> </input>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Longitud (grados decimales):</label>
                                                                <input class="form-control sistema" type="text"  name="longitud" id="longitud" value="{{$documento->longitud or old('longitud')}}" placeholder="ej: Paraná= -60.5238"> </input>
                                                            </div>
                                                        </div>
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
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody id="tabla_ubicacion">
                                                    @foreach($documento->temporal as $temporal)
                                                    <tr id="ubicacion_{{$temporal->id}}">
                                                        <td class="col-xs-3"><input type="text" value="{{$temporal->nro_plano}}" class="form-control modificar sistema" id="plano" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->grupo}}" name="grupo[]" class="form-control modificar sistema" id="gru" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->manzana}}" class="form-control modificar sistema" name="manzana[]" id="manz" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->parcela}}" class="form-control modificar sistema" name="parcela[]" id="parc" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->subparcela}}" name="subparcela[]" class="form-control sistema modificar" id="subparc" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->chacra}}" class="form-control modificar sistema" name="chacra[]" id="chac" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->quinta}}" class="form-control modificar sistema" name="quinta[]"  id="quint" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->lamina}}" name="lamina[]" class="form-control sistema modificar" id="lam" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$temporal->sublamina}}" class="form-control modificar sistema" name="sublamina[]" id="sublam" readonly></td>
                                                        <td class="col-xs-1"><a href="javascript:eliminar_registro('{{$temporal->id}}')"><i class="glyphicon glyphicon-remove" style="color: red"></i></a></td>
                                                      <tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
