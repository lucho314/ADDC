<style>
    .row.col-md-1{
        padding: 0px;
        margin-top: 2%;
    }
</style>
<div class="container-fluid"> 
    <div class="col-md-4"> 
        <div id="datosUbicacion" >
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group row">   <!--    posible_valor planta, Descripcion-->
                                <label>Tipo planta:</label>
                                <div class="col-md-11"> <select  name="gral[tipo_planta]" id="tipo_planta" class="form-control row">
                                        @foreach($plantas as $pl)
                                        @if(isset($datosSAT))
                                        <option value="{{$pl->posible_valor}}" <?= ($documento->temporal[0]->tipo_planta === $pl->posible_valor) ? 'selected' : '' ?>> {{$pl->descripcion}}</option>
                                        @else
                                        <option value="{{$pl->posible_valor}}"> {{$pl->descripcion}}</option>
                                        @endif
                                        @endforeach
                                    </select></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Superficie según mensura:</label>
                                <div class="col-md-11"><input class="form-control row" type="text"   value="0"  name="gral[sup_mensura]" id="sup_mensura" value="{{$documento->sup_mensura or ''}}"> </input></div><div class="row col-md-1"><label class="unidad">m2</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Superficie según título:</label>
                                <div class="col-md-11"><input class="row form-control" type="text"  value="0"  name="gral[sup_titulo]" id="sup_titulo" value="{{$documento->sup_titulo or ''}}"> </input></div><div class="row col-md-1"><label class="unidad">m2</label></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Exceso:</label>
                                <div class="col-md-11"><input class="row form-control" type="text"  value="0000"  name="gral[exeso]" id="exeso"  value="{{$documento->exeso or ''}}"> </input></div><div class="row col-md-1"><label class="unidad">m2</label></div>
                            </div>
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
                    <tbody id="tbody-seleccion-partidas">

                    </tbody>

                </table>
                <a class="btn btn-default btn-xs glyphicon glyphicon-plus" href="javascript:agregar_ubicacion()" style="float: right;margin-right: 1%;" id="agregar_partida"></a>
            </div>
        </div>
    </div>
</div>











