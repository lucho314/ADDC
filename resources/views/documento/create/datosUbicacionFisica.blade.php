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
                            <td><input class="form-control"  type="text" class='form-control'  readonly id="sector" required="required"  placeholder="Sector.."> </input></td>
                            <td><input class="form-control"  type="text" class='form-control'   readonly id="modulo" required="required"  placeholder="Módulo.."> </input></td>
                            <td><input class="form-control"  type="text" class='form-control'   readonly id="estante" required="required"  placeholder="Estante.."> </input></td>
                            <td><input class="form-control"  type="text" class='form-control'  readonly   id="posicion" placeholder="Posición.."></td>
                            <td><input class="form-control"  type="text" class='form-control'   readonly id="profundidad" placeholder="Profundidad.."> </input></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="alta_caja" style="display: none">
                <div class="form-group col-md-3">
                    <label>Sector:</label>
                    <input  type="text" class='form-control' readonly name="sector" id="sector_nuevo">
                </div>
                <div class="form-group col-md-3">
                    <label>Módulo:</label>
                    <input  type="text" class='form-control' readonly name="modulo" id="modulo_nuevo">
                </div>
                <div class="form-group col-md-3">
                    <label>Estante:</label>
                    <input  type="text" class='form-control' readonly name="estante" id="estante_nuevo">
                </div>
                <div class="form-group col-md-3">
                    <label>Posición:</label>
                    <input  type="text" class='form-control' readonly name="posicion" id="posicion_nuevo">
                </div>
                <div class="form-group col-md-3">
                    <label>Profundidad:</label>
                    <input  type="text" class='form-control' readonly name="profundidad" id="profundidad_nuevo">
                </div>
                <div class="form-group col-md-3">
                    <label>Número de caja:</label>
                    <input  type="text" class='form-control' readonly name="numero_caja" id="numero_caja">
                </div>
                <div class="form-group col-md-3">
                    <label>número desde:</label>
                    <input  type="text" class='form-control' readonly name="numero_desde" id="numero_desde">
                </div>

                <a class="btn btn-success" href="javascript:crear_caja()">Crear</a>

            </div>
        </div>

        <a class="fancybox fancybox.iframe btn btn-primary" href="{{URL::action('CajaController@create','min=sidebar-collapse')}}">Nueva caja</a>
    </div>
</div>
