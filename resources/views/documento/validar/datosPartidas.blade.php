<div class="container-fluid"> 
    <div class="col-md-2"> 
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group row">   <!--    posible_valor planta, Descripcion-->
                            <label>Tipo planta:</label>
                            <select  id="tipo_planta" class="form-control  select-modificar sistema" readonly onchange="$('#gral_tipo_planta').val(this.value)">
                                @foreach($plantas as $pl)
                                @if(isset($datosSAT))
                                <option value="{{$pl->posible_valor}}" <?= ($documento->documentoSat[0]->$relacion->tipo_planta_id === $pl->posible_valor) ? 'selected' : '' ?>> {{$pl->descripcion}}</option>
                                @else
                                <option value="{{$pl->posible_valor}}"> {{$pl->descripcion}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="errores"></div>
                </div>

            </div>

        </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default" id="datosPartidas">
            <div class="panel-body"  id="partidas">
                <table class="table table-border table-striped table-fixed">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Plano</th>
                            <th class="col-xs-2">Partida</th>
                            <th class="col-xs-2">Sup mensura</th>
                            <th class="col-xs-2">Sup Titulo</th>
                            <th class="col-xs-2">Exceso</th>
                            <th class="col-xs-2">Sup Edificada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documento->documentoSat as $key=>$documento)
                            @if($documento->vigente)
                            <?php $relacion=$documento->getDatosRelacionados()?>
                        <tr>
                            <td class="col-xs-2"><input type="text"  name="lote[{{$key}}][nro_plano]" value="{{$documento->nro_plano}}" class="form-control modificar sistema" id="lote_{{$key}}_nro_plano" readonly></td>
                            <td class="col-xs-2"><input type="text" value="{{$documento->nro_partida}}"  name="lote[{{$key}}][nro_partida]" class="form-control modificar sistema" id="lote_{{$key}}_nro_partida" readonly></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->$relacion->sup_terreno}}" id="lote_{{$key}}_sup_terreno" class="form-control modificar sistema"  name="lote[{{$key}}][sup_terreno]" readonly></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->sup_titulo}}" id="lote_{{$key}}_sup_titulo"  class="form-control modificar sistema"  name="lote[{{$key}}][sup_titulo]" readonly></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->exceso}}" id="lote_{{$key}}_sup_exceso" class="form-control modificar sistema"  name="lote[{{$key}}][exeso]" readonly></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->$relacion->sup_edif_total}}" id="lote_{{$key}}_sup_edificada" class="form-control modificar sistema" readonly  name="lote[{{$key}}][sup_edificada]"></div><label class="col-xs-1">{{$unidadMedida}}</label></td>

                            <input type="hidden"  name="lote[{{$key}}][imponible_id]" value="{{$documento->imponible_id}}">
                        </tr>
                            @elseif(!is_null($documento->imponible_id))
                              <tr>
                                    <td class="col-xs-2"><input type="text" name="lote[{{$key}}][nro_plano]" value="{{$documento->nro_plano}}" class="form-control modificar sistema" id="lote_{{$key}}_nro_plano" readonly></td>
                                    <td class="col-xs-10" colspan="5"><input class='form-control' type="text" readonly  value="PLANO NO VIGENTE"></td>
                              </tr>
                              @else
                              <tr>
                                    <td class="col-xs-2"><input type="text" name="lote[{{$key}}][nro_plano]" value="{{$documento->nro_plano}}" class="form-control modificar sistema" id="lote_{{$key}}_nro_plano" readonly></td>
                                    <td class="col-xs-2"><input class='form-control' type="text" readonly  value="{{$documento->nro_partida}}"></td>
                                    <td class="col-xs-8" colspan="4"><input class='form-control' type="text" readonly  value="SIN DATOS"></td>
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