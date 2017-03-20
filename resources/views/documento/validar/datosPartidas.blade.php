<div class="container-fluid"> 
    <div class="col-md-4"> 
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">   <!--    posible_valor planta, Descripcion-->
                            <label>Tipo planta:</label>
                            <select  name="gral[tipo_planta]" id="tipo_planta" class="form-control ingresado" readonly>
                                @foreach($plantas as $pl)
                                @if(isset($datosSAT))
                                <option value="{{$pl->posible_valor}}" <?= ($documento->temporal[0]->tipo_planta === $pl->posible_valor) ? 'selected' : '' ?>> {{$pl->descripcion}}</option>
                                @else
                                <option value="{{$pl->posible_valor}}"> {{$pl->descripcion}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Superficie según mensura:</label>
                            <input class="form-control ingresado" type="text"    name="gral[sup_mensura]" id="sup_mensura" value="{{$documento->sup_mensura or 0}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Superficie según título:</label>
                            <input class="form-control ingresado" type="text"    name="gral[sup_titulo]" id="sup_titulo" value="{{$documento->sup_titulo or 0}}"> </input>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Exceso:</label>
                            <input class="form-control ingresado" type="text"  name="gral[exeso]" id="exeso"  value="{{$documento->exeso or 0}}"> </input>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default" id="datosPartidas">
            <div class="panel-body"  id="partidas">
                <table class="table table-border table-striped table-fixed">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Plano</th>
                            <th class="col-xs-3">Partida</th>
                            <th class="col-xs-3">Sup Terreno</th>
                            <th class="col-xs-3">Sup Edificada</th>
                            <th class="col-xs-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documento->temporal as $key=>$temporal)
                        <tr id="{{$temporal->id}}">
                            <td class="col-xs-2"><input type="text"  name="lote[{{$key}}][nro_plano]" value="{{$temporal->nro_plano}}" class="form-control modificar sistema" id="plano" readonly></td>
                            <td class="col-xs-3"><input type="text" value="{{$temporal->nro_partida}}"  name="lote[{{$key}}][nro_partida]" class="form-control modificar sistema" id="part" readonly></td>
                            <td class="col-xs-3"><div class="row col-xs-11"><input type="text" value="{{$temporal->sup_terreno}}" id="terreno" class="form-control modificar sistema"  name="lote[{{$key}}][sup_terreno]" readonly></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-3"><div class="row col-xs-11"><input type="text" value="{{$temporal->sup_edificada}}" id="edificada" class="form-control modificar sistema" readonly  name="lote[{{$key}}][sup_edificada]"></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-1"><a href="javascript:eliminar_registro('{{$temporal->id}}')"><i class="glyphicon glyphicon-remove" style="color: red"></i></a></td>
                            <input type="hidden"  name="lote[{{$key}}][temporal_id]" value="{{$temporal->id}}">
                            <input type="hidden"  name="lote[{{$key}}][imponible_id]" value="{{$temporal->imponible_id}}">
                            <input type="hidden"  name="lote[{{$key}}][catastro_id]" value="{{$temporal->catastro_id}}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>