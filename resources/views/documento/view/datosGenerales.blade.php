<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
           <div class="col-md-10">

                <div  id="datosGenerales">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control" type="text"name="nro_dpto" disabled  value="{{$documento->nro_dpto or old('nidombre')}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control" type="text"  name="nro_plano" disabled  value="{{$documento->nro_plano or old('nombre')}}"> </input>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control" type="text"  name="nro_plano_hasta" disabled  value="{{$documento->nro_plano_hasta or old('nombre')}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de documento:</label>
                            <select class="form-control" name="tipo_doc" disabled>
                                @if(isset($documento->fecha_registro))
                                <option <?= ($documento->tipo_doc === '1') ? 'selected' : ''; ?>>Plano de mensura</option>
                                <option <?= ($documento->tipo_doc === '2') ? 'selected' : ''; ?>>Ficha de transferencia</option>
                                @else
                                <option value="1">Plano de mensura</option>
                                <option value="2">Ficha de transferencia</option>
                                @endif
                            </select>

                        </div> 
                    </div>
                    @if($documento->tipo_doc_id == '2')
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Certificado</label>
                            <input class="form-control" type="text"  name="gral['certificado]" disabled value="{{$documento->certificado or old('certificado')}}" placeholder="Certificado.."> </input>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha certificado</label>
                            <input class="form-control" type="date"   disabled  value="{{($documento->fecha_certificado)?$documento->fecha_certificado->toDateString():''}}"> </input>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de registro:</label>
                            @if(isset($documento->fecha_registro))
                            <div class="col-md-11 row"><input class="form-control" disabled type="date"  name="gral[fecha_registro]"  value="{{$documento->fecha_registro->toDateString()}}"  id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input  disabled type="checkbox" <?= ($documento->fecha_registro_visible==='1')? 'checked':'' ?> title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @else
                            <div class="col-md-11 row"><input class="form-control" type="date" disabled  name="gral[fecha_registro]"   id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input type="checkbox" disabled value='1' title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Año de inscripción</label>
                            <input class="form-control" type="text"  name="inscripcion" disabled value="{{$vigente->$relacion->inscripcion or old('nombre')}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input class="form-control" type="text"  name="nro_matricula"  disabled  value="{{$documento->nro_matricula or old('nombre')}}"> </input>
                        </div>
                    </div>
                      @if($documento->tipo_doc_id == 1)
                    <div class="col-md-3" id="grupo-objeto">
                        <div class="form-group">
                            <label>Objeto</label>
                            <select class="form-control"  name="gral[objeto_id]" disabled>
                                @foreach($objetos as $obj)
                                <option value="{{$obj->id}}" <?= ($documento->objeto_id == $obj->id) ? 'selected' : '' ?>>{{$obj->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                  
                 </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Antecedentes </label>   
                    @foreach($documento->antecedentes as $ant)
                    <div class="col-md-10">
                        <input type="text" value="{{$ant->nro_plano}}" placeholder="Nro plano antecedente" disabled class="form-control" style="margin-bottom: 6%">
                    </div>  
                    <div class="row col-md-2" style="margin-top: 3%">
                        <a href="javascript:verAntecedente({{$ant->nro_plano}}, '{{$documento->nro_dpto}}')" title="Ver antecedente">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </a>
                    </div>
                    @endforeach 
                </div>
            </div>
        </div>
    </div>
</div>



