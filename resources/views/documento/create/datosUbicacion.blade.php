
<div class="container-fluid"> 
    <div class="col-md-4">
        <div id="datosUbicacion" >

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Departamento</label>
                            <select  id="departamento" class="form-control select-modificar" readonly  name="departamento_id">
                            </select> 
                           </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distrito</label>
                            <select id="distrito" class="form-control select-modificar" readonly name="distrito_id">
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Localidad</label>
                            <select id="localidad" class="form-control select-modificar" readonly name="localidad_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sección</label>
                            <input class="form-control modificar" type="text" readonly  name="gral[seccion]" id="gral_seccion" value="{{$documento->temporal[0]->seccion or old('nombre')}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Latitud (grados decimales):</label>
                            <input class="form-control modificar" type="text"   name="gral[latitud]" id="gral_latitud" value="{{$documento->latitud or old('latitud')}}" placeholder=" ej: Paraná= -31.73197"> </input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Longitud (grados decimales):</label>
                            <input class="form-control modificar" type="text"   name="gral[longitud]" id="gral_longitud" value="{{$documento->longitud or old('longitud')}}" placeholder="ej: Paraná= -60.5238"> </input>
                        </div>
                    </div>
                    <div class="col-md-12  errores"></div>
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
                            <th class="col-xs-1">Grupo</th>
                            <th class="col-xs-1">Manzana</th>
                            <th class="col-xs-1">Parcela</th>
                            <th class="col-xs-1">Subparcela</th>
                            <th class="col-xs-1">Chacra</th>
                            <th class="col-xs-1">Quinta</th>
                            <th class="col-xs-1">Lamina</th>
                            <th class="col-xs-1">Sublamina</th>

                        </tr>
                    </thead>
                    <tbody id="tabla_ubicacion">

                    </tbody>
                </table>
                <a class="btn btn-default btn-xs glyphicon glyphicon-plus agregar_" style="display: none" href="javascript:agregar_ubicacion()" style="float: right;margin-right: 0.3%;" id="agregar_ubicacion"></a>
            <div class="col-md-12  errores"></div>
            </div>
        </div>
    </div>
</div>
