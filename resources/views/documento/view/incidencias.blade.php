
<div class="container">  
    <div class="col-md-12">
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
</div>
