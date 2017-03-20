<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">

            <div id="datosUbicacionFisica">
                <table class="table table-border table-striped">
                    <thead>
                        <tr>
                            <th>Sector</th>
                            <th>Módulo</th>
                            <th>Estante</th>
                            <th>Posición</th>
                            <th>Profundidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-control"  type="text" class='form-control'  readonly id="sector"  value="{{$ubicacionFisica->caja->sector or ''}}"  required="required"  placeholder="Sector.."> </input></td>
                            <td><input class="form-control"  type="text" class='form-control'   readonly id="modulo" value="{{$ubicacionFisica->caja->modulo or ''}}" required="required"  placeholder="Módulo.."> </input></td>
                            <td><input class="form-control"  type="text" class='form-control'   readonly id="estante" value="{{$ubicacionFisica->caja->estante or ''}}" required="required"  placeholder="Estante.."> </input></td>
                            <td><input class="form-control"  type="text" class='form-control'  readonly   id="posicion" value="{{$ubicacionFisica->caja->posicion or ''}}"  placeholder="Posición.."></td>
                            <td><input class="form-control"  type="text" class='form-control'   readonly id="profundidad" value="{{$ubicacionFisica->caja->profundidad or ''}}" placeholder="Profundidad.."> </input></td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
