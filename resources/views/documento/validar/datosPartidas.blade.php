<div class="container-fluid"> 
    <div class="col-md-4"> 
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group row">   <!--    posible_valor planta, Descripcion-->
                                <div class="col-md-10">     
                                <label>Tipo planta:</label>
                                @if(strpos($documento->temporal[0]->tipo_planta, '*'))
                               
                                    <select  id="tipo_planta" class="form-control select-modificar" style="border: solid 2px #f97a7a;background-color: #f9dede;" readonly onchange="$('#gral_tipo_planta').val(this.value)">
                                        @else
                                        <select  id="tipo_planta" class="form-control  select-modificar sistema" readonly onchange="$('#gral_tipo_planta').val(this.value)">
                                            @endif

                                            @foreach($plantas as $pl)
                                            @if(isset($datosSAT))
                                            <option value="{{$pl->posible_valor}}" <?= ($documento->temporal[0]->tipo_planta === $pl->posible_valor) ? 'selected' : '' ?>> {{$pl->descripcion}}</option>
                                            @else
                                            <option value="{{$pl->posible_valor}}"> {{$pl->descripcion}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                </div>
                                <input type="hidden"  name="gral[tipo_planta]" id="gral_tipo_planta" value="{{$documento->temporal[0]->tipo_planta}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Superficie según mensura:</label>
                                <div class="col-md-11"><input class="form-control ingresado row" type="text"  name="gral[sup_mensura]" id="gral_sup_mensura" value="{{$documento->sup_mensura or ''}}"> </input></div><div class="row col-md-1"><label class="unidad">{{$unidadMedida}}</label></div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Superficie según título:</label>
                                <div class="col-md-11"><input class="form-control ingresado row" type="text" name="gral[sup_titulo]" id="gral_sup_titulo" value="{{$documento->sup_titulo or ''}}"> </input></div><div class="row col-md-1"><label class="unidad">{{$unidadMedida}}</label></div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Exceso:</label>
                                <div class="col-md-11"><input class="form-control ingresado row" type="text" name="gral[exeso]" id="gral_exeso" value="{{$documento->exeso or ''}}"> </input></div><div class="row col-md-1"><label class="unidad">{{$unidadMedida}}</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="errores"></div>
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
                            <td class="col-xs-2"><input type="text"  name="lote[{{$key}}][nro_plano]" value="{{$temporal->nro_plano}}" class="form-control modificar sistema" id="lote_{{$key}}_nro_plano" readonly></td>
                            <td class="col-xs-3"><input type="text" value="{{$temporal->nro_partida}}"  name="lote[{{$key}}][nro_partida]" class="form-control modificar sistema" id="lote_{{$key}}_nro_partida" readonly></td>
                            <td class="col-xs-3"><div class="row col-xs-11"><input type="text" value="{{$temporal->sup_terreno}}" id="lote_{{$key}}_sup_terreno" class="form-control modificar sistema"  name="lote[{{$key}}][sup_terreno]" readonly></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-3"><div class="row col-xs-11"><input type="text" value="{{$temporal->sup_edificada}}" id="lote_{{$key}}_sup_edificada" class="form-control modificar sistema" readonly  name="lote[{{$key}}][sup_edificada]"></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td class="col-xs-1"><a href="javascript:eliminar_registro('{{$temporal->id}}')"><i class="glyphicon glyphicon-remove" style="color: red"></i></a></td>
                    <input type="hidden"  name="lote[{{$key}}][temporal_id]" value="{{$temporal->id}}">
                    <input type="hidden"  name="lote[{{$key}}][imponible_id]" value="{{$temporal->imponible_id}}">
                    <input type="hidden"  name="lote[{{$key}}][catastro_id]" value="{{$temporal->catastro_id}}">
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="errores"></div>
            </div>

        </div>
    </div>
</div>