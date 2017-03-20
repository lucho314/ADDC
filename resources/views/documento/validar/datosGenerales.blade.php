<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8 col-md-offset-1">
                <div  id="datosGenerales">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control ingresado" type="text"  name="gral[nro_dpto]" id="nro_dpto" required="required" readonly value="{{$documento->nro_dpto or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control ingresado" type="text"   name="gral[nro_plano]" id="nro_plano" required="required" readonly value="{{$documento->nro_plano or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control ingresado" type="text"   name="gral[nro_plano_hasta]" id="nro_plano_hasta" required="required" readonly value="{{$documento->nro_plano_hasta or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo de documento:</label>
                            <select class="form-control ingresado"  name="gral[tipo_doc]" id="tipo_doc" readonly>
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
                            <input class="form-control ingresado" type="date"   name="gral[fecha_registro]" id="fecha_registro" value="{{$documento->fecha_registro->toDateString()}}" placeholder="Codigo de producto.."> </input>
                            @else
                            <input class="form-control ingresado" type="date"   name="gral[fecha_registro]" id="fecha_registro">
                            @endif

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Año de inscripción</label>
                            <input class="form-control modificar sistema" type="text"  readonly  name="gral[inscripcion]" id="inscripcion" value="{{$documento->temporal[0]->inscripcion or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input class="form-control modificar sistema" type="text"   name="gral[nro_matricula]" readonly id="matricula" value="{{$documento->temporal[0]->nro_matricula or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Responsable</label>
                            <input class="form-control ingresado" type="text" readonly  required  name="gral[responsable]" id="responsable" value="{{$documento->responsable or old('responsable')}}" placeholder="Responsable.."> </input>
                        </div>
                    </div>

                    <div class="col-md-4" id="grupo-objeto">
                        <div class="form-group">
                            <label>Objeto</label>
                            <select class="form-control ingresado"  name="gral[objeto_id]" readonly>
                                @foreach($objetos as $obj)
                                <option value="{{$obj->id}}" <?= ($documento->objeto_id == $obj->id) ? 'selected' : '' ?>>{{$obj->descripcion}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                </div></div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="form-inline"><label>Antecedentes </label><a href="javascript:agregar_antecedente()"><i class="glyphicon glyphicon-plus" style="margin-left: 4%"></i></a></div>                        
                    <div id="grupo_antecedente">
                        @foreach($documento->antecedentes as $ant)
                        <input type="text" value="{{$ant->nro_plano}}" placeholder="Nro plano antecedente" readonly  name="plano_ant[]" class="form-control ingresado" style="margin-bottom: 6%">
                        @endforeach 
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>
