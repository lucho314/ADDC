<style>
    .row.col-md-1{
        padding: 0px;
        margin-top: 2%;
    }
</style>
<div class="container-fluid"> 
    <div class="col-md-2"> 
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                            <div class="form-group row">   <!--    posible_valor planta, Descripcion-->
                                <label>Tipo planta:</label>
                                <div class="col-md-11"> <select  id="tipo_planta" name="tipo_planta_id" class="form-control select-modificar row">
                                        @foreach($plantas as $pl)
                                        @if(isset($datosSAT))
                                        <option value="{{$pl->posible_valor}}" <?= ($documento->temporal[0]->tipo_planta === $pl->posible_valor) ? 'selected' : '' ?>> {{$pl->descripcion}}</option>
                                        @else
                                        <option value="{{$pl->posible_valor}}"> {{$pl->descripcion}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="gral[tipo_planta]" id="tipo_planta_input">
                            </div>
                    </div>
                    <div class="col-md-12  errores"></div>
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
                            <th class="col-xs-2">Sup Mensura</th>
                            <th class="col-xs-2">Sup Titulo</th>
                            <th class="col-xs-2">Exceso</th>
                            <th class="col-xs-2">Sup Edificada</th>
                        </tr>
                    <tbody id="tbody-seleccion-partidas">

                    </tbody>

                </table>
                <a class="btn btn-default btn-xs glyphicon glyphicon-plus agregar_" style="display: none" href="javascript:agregar_ubicacion()" style="float: right;margin-right: 1%;" id="agregar_partida"></a>
                <div class="col-md-12  errores"></div>
            </div>
        </div>
    </div>
</div>











