<div class="container-fluid"> 
    <div class="col-md-2"> 
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group row">   <!--    posible_valor planta, Descripcion-->
                            <label>Tipo planta:</label>
                            <select  id="tipo_planta" class="form-control" disabled>
                                @foreach($plantas as $pl)
                                @if(isset($datosSAT))
                                <option value="{{$pl->posible_valor}}" <?= ($vigente->$relacion->tipo_planta_id === $pl->posible_valor) ? 'selected' : '' ?>> {{$pl->descripcion}}</option>
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
                        <?php $relacion = $documento->getDatosRelacionados() ?>
                        <tr>
                            <td class="col-xs-2"><input type="text"   value="{{$documento->nro_plano}}" class="form-control" id="lote_{{$key}}_nro_plano" disabled></td>
                            <td class="col-xs-2"><input type="text" value="{{$documento->nro_partida}}"  class="form-control" id="lote_{{$key}}_nro_partida" disabled></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->$relacion->sup_terreno}}" id="lote_{{$key}}_sup_terreno" class="form-control"  disabled></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->sup_titulo}}" id="lote_{{$key}}_sup_titulo"  class="form-control"   disabled></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->exceso}}" id="lote_{{$key}}_sup_exceso" class="form-control"   disabled></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-2"><div class="row col-xs-11"><input type="text" value="{{$documento->$relacion->sup_edif_total}}" id="lote_{{$key}}_sup_edificada" class="form-control" disabled></div><label class="col-xs-1">{{$unidadMedida}}</label></td>

                    <input type="hidden"  name="lote[{{$key}}][imponible_id]" value="{{$documento->imponible_id}}">
                    </tr>
                    @elseif(!is_null($documento->imponible_id))
                        <tr>
                            <td class="col-xs-2"><input type="text"  value="{{$documento->nro_plano}}" class="form-control" id="lote_{{$key}}_nro_plano" disabled></td>
                            <td class="col-xs-10" colspan="5"><input class='form-control' type="text" disabled  value="PLANO NO VIGENTE"></td>
                        </tr>
                    @else
                        <tr>
                            <td class="col-xs-2"><input type="text"  value="{{$documento->nro_plano}}" class="form-control" id="lote_{{$key}}_nro_plano" disabled></td>
                            <td class="col-xs-10" colspan="5"><input class='form-control' type="text" disabled  value="SIN DATOS"></td>
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