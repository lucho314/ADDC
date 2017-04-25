<style>
    thead, tbody { display: block; }

    tbody {
        height: 200px;       /* Just for the demo          */
        overflow-y: auto;    /* Trigger vertical scroll    */
        overflow-x: hidden;  /* Hide the horizontal scroll */
    }
</style>
<div class="container-fluid"> 
    <div class="col-md-4">
        <div id="datosUbicacion" >

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Departamento</label>
                            <select name="departamento" id="departamento" class="form-control">
                                @foreach($dptos as $dpto) 
                                <option value="{{$dpto->div_de}}" 
                                        <?= ($dpto->div_de == $documento->temporal[0]->departamento) ? 'selected' : '' ?>>{{$dpto->departamento}} 
                                </option>
                                @endforeach
                            </select> 

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distrito</label>
                            <select name="distrito" id="distrito" class="form-control">
                                @foreach($dtos as $dto) 
                                <option value="{{$dto->div_di}}" 
                                        <?= ($dto->div_di == $documento->temporal[0]->distrito) ? 'selected' : '' ?>>{{$dto->distrito}} 
                                </option>
                                @endforeach
                            </select> 

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Localidad</label>
                            <select name="localidad" id="localidad" class="form-control">
                                @foreach($localidades as $loc) 
                                <option value="{{$loc->div_lo}}" 
                                        <?= ($loc->div_lo == $documento->temporal[0]->localidad) ? 'selected' : '' ?>>{{$loc->localidad}} 
                                </option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Seccion</label>
                                <input class="form-control" type="text" readonly name="seccion" id="seccion" value="{{$documento->temporal[0]->seccion or old('nombre')}}"> </input>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-border table-striped">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Grupo</th>
                            <th>Manzana</th>
                            <th>Parcela</th>
                            <th>Subparcela</th>
                            <th>Chacra</th>
                            <th>Quinta</th>
                            <th>Lamina</th>
                            <th>Sublamina</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_ubicacion">
                        @foreach($documento->temporal as $temporal)
                        <tr>
                            <td>{{$temporal->nro_plano}}</td>
                            <td><input type="text" value="{{$temporal->grupo}}" name="grupo[]" class="form-control" readonly></td>
                            <td><input type="text" value="{{$temporal->manzana}}" class="form-control" name="manzana[]" readonly></td>
                            <td><input type="text" value="{{$temporal->parcela}}" class="form-control" name="parcela[]" readonly></td>
                            <td><input type="text" value="{{$temporal->subparcela}}" name="subparcela[]" class="form-control" readonly></td>
                            <td><input type="text" value="{{$temporal->chacra}}" class="form-control" name="chacra[]" readonly></td>
                            <td><input type="text" value="{{$temporal->quinta}}" class="form-control" name="quinta[]" readonly></td>
                            <td><input type="text" value="{{$temporal->lamina}}" name="lamina[]" class="form-control" readonly></td>
                            <td><input type="text" value="{{$temporal->sublamina}}" class="form-control" name="sublamina[]" readonly></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
