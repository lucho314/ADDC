<div class="container-fluid"> 
    <div class="col-md-4">
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Departamento</label>
                                <select  id="departamento" class="form-control select-modificar sistema" readonly onchange="$('#gral_departamento').val(this.value)"> 
                                    @foreach($dptos as $dpto) 
                                    <option value="{{$dpto->div_de}}" 
                                            <?= ($dpto->div_de ==  $documento->documentoSat[0]->datosSat->div_de) ? 'selected' : '' ?>>{{$dpto->departamento}} 
                                    </option>
                                    @endforeach
                                </select> 
                              </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Distrito</label>
                                              <select id="distrito" readonly class="form-control select-modificar sistema" onchange="$('#gral_distrito').val(this.value)">
                                                
                                                @foreach($dtos as $dto) 
                                                <option value="{{$dto->div_di}}" 
                                                        <?= ($dto->div_di ==$documento->documentoSat[0]->datosSat->div_di) ? 'selected' : '' ?>>{{$dto->distrito}} 
                                                </option>
                                                @endforeach
                                            </select> 
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Localidad</label>
                                                        <select  readonly id="localidad" class="form-control select-modificar sistema" onchange="$('#gral_localidad').val(this.value)">
                                                            @foreach($localidades as $loc) 
                                                            <option value="{{$loc->div_lo}}" 
                                                                    <?= ($loc->div_lo ==$documento->documentoSat[0]->datosSat->div_lo ) ? 'selected' : '' ?>>{{$loc->localidad}} 
                                                            </option>
                                                            @endforeach
                                                        </select> 
                                                        </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Sección</label>
                                                                <input class="form-control modificar sistema" type="text" readonly  name="gral[seccion]" id="gral_seccion" value="{{$documento->documentoSat[0]->datosSat->seccion}}" placeholder="Codigo de producto.."> </input>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Latitud (grados decimales):</label>
                                                                <input class="form-control sistema" type="text"   name="gral[latitud]" id="gral_latitud" value="" placeholder=" ej: Paraná= -31.73197"> </input>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Longitud (grados decimales):</label>
                                                                <input class="form-control sistema" type="text"   name="gral[longitud]" id="gral_longitud" value="" placeholder="ej: Paraná= -60.5238"> </input>
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

                                                    </tr>
                                                </thead>
                                                <tbody id="tabla_ubicacion">
                                                    @foreach($documento->documentoSat as $key=>$documento)
                                                    <tr>
                                                        <td class="col-xs-3"><input type="text" value="{{$documento->nro_plano}}" class="form-control modificar sistema" id="plano" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->grupo}}"  name="lote[{{$key}}][grupo]" class="form-control modificar sistema" id="lote_{{$key}}_grupo" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->manzana}}" class="form-control modificar sistema"  name="lote[{{$key}}][manzana]" id="lote_{{$key}}_manzana" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->parcela}}" class="form-control modificar sistema"  name="lote[{{$key}}][parcela]" id="lote_{{$key}}_parcela" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->subparcela}}"  name="lote[{{$key}}][subparcela]" class="form-control sistema modificar" id="lote_{{$key}}_subparcela" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->chacra}}" class="form-control modificar sistema"  name="lote[{{$key}}][chacra]" id="lote_{{$key}}_chacra" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->quinta}}" class="form-control modificar sistema"  name="lote[{{$key}}][quinta]"  id="lote_{{$key}}_quinta" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->lamina}}"  name="lote[{{$key}}][lamina]" class="form-control sistema modificar" id="lote_{{$key}}_lamina" readonly></td>
                                                        <td class="col-xs-1"><input type="text" value="{{$documento->datosSat->sublamina}}" class="form-control modificar sistema"  name="lote[{{$key}}][sublamina]" id="lote_{{$key}}_sublamina" readonly></td>
                                                    <tr>
                                                        @endforeach
                                                </tbody>
                                            </table>
                                            <div class="errores"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
