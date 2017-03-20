
<div class="container">  
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-border table-striped table-fixed">
                    <thead>
                        <tr>
                            <th class="col-md-4">Fecha</th>
                            <th class="col-md-4">Usuario</th>
                            <th class="col-md-4">Descripcion</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_ubicacion">
                      @foreach($incidencias as $inc)
                      <tr>
                       <td class="col-md-4">{{$inc->fecha_cambio}}</td>
                       <td class="col-md-4">{{$inc->user1_id}}</td>
                       <td class="col-md-4">{{$inc->descripcion}}</td>
                      </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
