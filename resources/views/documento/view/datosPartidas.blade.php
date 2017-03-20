<div class="container-fluid"> 
    <div class="col-md-4"> 
        <div id="datosUbicacion" >

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">   <!--    posible_valor planta, Descripcion-->
                            <label>Tipo planta:</label>
                            <select name="tipo_planta" disabled class="form-control">
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
                            <input class="form-control" type="text"   name="sup_mensura" disabled value="{{$documento->sup_mensura or 0}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Superficie según título:</label>
                            <input class="form-control" type="text"   name="sup_titulo" disabled value="{{$documento->sup_titulo or 0}}"> </input>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Exceso:</label>
                            <input class="form-control" type="text" name="exeso" disabled  value="{{$documento->exeso or 0}}"> </input>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default" id="datosPartidas">
            <div class="panel-body"  id="partidas">
                <table class="table table-border table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Partida</th>
                            <th>Sup Terreno</th>
                            <th>Sup Edificada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documento->temporal as $temporal)
                        <tr>
                            <td>{{$temporal->nro_plano}}</td>
                            <td><input type="text" value="{{$temporal->nro_partida}}" class="form-control" disabled></td>
                            <td><div class="row col-xs-11"><input  disabled type="text" value="{{$temporal->sup_terreno}}" class="form-control" name="sup_terreno[]" ></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <td><div class="row col-xs-11"><input disabled type="text" value="{{$temporal->sup_edificada}}" class="form-control"  name="sup_edificada[]"></div><label class="col-xs-1">{{$unidadMedida}}</label></td>
                            <input type="hidden" name="plano[]" value="{{$temporal->nro_plano}}">
                            <input type="hidden" name="partida[]" value="{{$temporal->nro_partida}}">
                            <input type="hidden" name="temporal_id[]" value="{{$temporal->id}}">
                            <input type="hidden" name="imponible_id[]" value="{{$temporal->imponible_id}}">
                            <input type="hidden" name="catastro_id[]" value="{{$temporal->catastro_id}}">
                    </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


