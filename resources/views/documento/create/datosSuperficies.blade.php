<div class="panel panel-default" id="datos">
    <div class="panel-heading">
        <a href="#"  data-toggle="collapse" data-target="#datosSuperficie"><div style="width:100%;" id="tituloPanel">Superficies</div></a>
    </div>
    <div class="panel-body collapse"  id="datosSuperficie" >
        <div class="col-md-6">
            <div class="form-group">   <!--    posible_valor planta, Descripcion-->
                <label>Tipo planta:</label>
                <select name="tipo_planta" id="tipo_planta" class="form-control">
                    @foreach($plantas as $pl)
                    @if(isset($datosSAT))
                         <option value="{{$pl->posible_valor}}" <?= ($documento->temporal[0]->tipo_planta===$pl->posible_valor)? 'selected':'' ?>> {{$pl->descripcion}}</option>
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
                <input class="form-control" type="text"   value="0" name="sup_mensura" id="sup_mensura" value="{{$documento->sup_mensura or ''}}"> </input>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Superficie según título:</label>
                <input class="form-control" type="text"  value="0" name="sup_titulo" id="sup_titulo" value="{{$documento->sup_titulo or ''}}"> </input>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label>Exeso:</label>
                <input class="form-control" type="text"  value="0000" name="exeso" id="exeso"  value="{{$documento->exeso or ''}}"> </input>
            </div>
        </div>
    </div>
    <div class="col-md-12  errores"></div>
</div>
 