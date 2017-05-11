
<div class="container">

    <div class="panel panel-default" id="datos">
        <div class="panel-heading">
            <h3 class="panel-title">Titular</h3>
        </div>
        <div class="panel-body"  id="datosSuperficie" >
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-4 text-right"><b>Cuit/Cuil:</b></div>
                    <div class="col-md-8">{{$vigente->datosSat->titular->cuit}}</div>
                </div>
                <div class="form-group">
                    <div class="col-md-4  text-right"><b>Tipo y N° documento:</b></div> 
                    <div class="col-md-8">{{$vigente->datosSat->titular->tipo_documento}} {{$vigente->datosSat->titular->numero_documento}}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-4 text-right"><b>Contribuyente:</b></div> 
                    <div class="col-md-8">{{$vigente->datosSat->titular->nombre_completo}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default" id="datos">
        <div class="panel-heading">
            <h3 class="panel-title">Responsables</h3>
        </div>
        <div class="panel-body"  id="datosSuperficie" >
            <table class="table table-border table-striped table-fixed" id="tabla-responsables">
                <thead>
                    <tr>
                        <th class="col-xs-2">Cuit</th>
                        <th class="col-xs-4">Nombre</th>
                        <th class="col-xs-2">Fecha Ocupacion</th>
                        <th class="col-xs-2">Tipo de ocupacion</th>
                        <th class="col-xs-2">Porc. condominio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vigente->responsables as $resp)
                    <tr>        
                        <td class="col-xs-2">{{$resp->persona->cuit}}</td>
                        <td class="col-xs-4">{{$resp->persona->nombre_completo}}</td>
                        <td class="col-xs-2">{{$resp->fecha_ocupacion->format('d/m/Y')}}</td>
                        <td class="col-xs-2">{{$resp->tipoOcupacion->ocupacion}}</td>
                        <td class="col-xs-2">{{$resp->porcentaje_condominio}} %</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
