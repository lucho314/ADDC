<div class="container" >
    <div class="panel panel-default">
        <div class="panel-body">


            <div  id="datosGenerales">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nro Departamento:</label>
                        <input class="form-control" type="text"name="nro_dpto" disabled required="required" value="{{$documento->nro_dpto or old('nidombre')}}" placeholder="Codigo de producto.."> </input>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nro de plano desde:</label>
                        <input class="form-control" type="text"  name="nro_plano" disabled required="required" value="{{$documento->nro_plano or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nro de plano hasta:</label>
                        <input class="form-control" type="text"  name="nro_plano_hasta" disabled required="required" value="{{$documento->nro_plano_hasta or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select class="form-control" name="tipo_doc" disabled>
                            @if(isset($documento->fecha_registro))
                            <option <?= ($documento->tipo_doc === 'Plano de mensura') ? 'selected' : ''; ?> >Plano de mensura</option>
                            <option <?= ($documento->tipo_doc === 'Ficha de transferencia') ? 'selected' : ''; ?> >Ficha de transferencia</option>
                            @else
                            <option>Plano de mensura</option>
                            <option>Ficha de transferencia</option>
                            @endif
                        </select>

                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha de registro:</label>
                        @if(isset($documento->fecha_registro))
                        <input class="form-control" type="date" name="fecha_registro"  disabled value="{{$documento->fecha_registro->toDateString()}}" placeholder="Codigo de producto.."> </input>
                        @else
                        <input class="form-control" type="date" name="fecha_registro"   disabled>
                        @endif

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Año de inscripción</label>
                        <input class="form-control modificar" type="text"  name="inscripcion" disabled value="{{$documento->temporal[0]->inscripcion or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Matrícula</label>
                        <input class="form-control modificar" type="text"  name="nro_matricula"  disabled  value="{{$documento->temporal[0]->nro_matricula or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                    </div>
                </div>

              </div>
        </div>
    </div>
</div>