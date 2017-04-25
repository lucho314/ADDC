
<div class="container-fluid">  
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-border table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_ubicacion">
                      @foreach($documento->incidencias as $inc)
                      <tr>
                       <td>{{$inc->fecha}}</td>
                       <td>{{$inc->nom_usuario}}</td>
                       <td>{{$inc->descripcion}}</td>
                      </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-border table-striped">
                    <thead style="background: #f9dede;">
                        <tr>
                            <th>Campo</th>
                            <th>Valor original</th>
                            <th>Valor modificado</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_ubicacion">
                      @foreach($documento->cambios as $l)
                      <tr>
                       <td>{{ucwords(str_replace('_',' ',$l->campo))}}</td>
                       <td>{{$l->val_original}}</td>
                       <td>{{$l->val_cambio}}</td>
                      </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
