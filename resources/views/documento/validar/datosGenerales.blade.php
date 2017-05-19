<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-10">
                <div  id="datosGenerales" class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control ingresado" type="text"  name="gral[nro_dpto]" id="gral_nro_dpto" required="required" readonly value="{{$documento->nro_dpto or old('nombre')}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control ingresado" type="text"   name="gral[nro_plano]" id="gral_nro_plano" required="required" readonly value="{{$documento->nro_plano or old('nombre')}}"> </input>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control ingresado" type="text"   name="gral[nro_plano_hasta]" id="gral_nro_plano_hasta" required="required" readonly value="{{$documento->nro_plano_hasta or old('nombre')}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de documento:</label>

                            <select class="form-control ingresado"  name="gral[tipo_doc_id]" id="gral_tipo_doc" readonly>
                                @if($documento->tipo_doc_id!='')
                                <option value="1" <?= ($documento->tipo_doc_id === '1') ? 'selected' : ''; ?>>Plano de mensura</option>
                                <option value="2" <?= ($documento->tipo_doc_id === '2') ? 'selected' : ''; ?> >Ficha de transferencia</option>
                                @else
                                <option value="1">Plano de mensura</option>
                                <option value="2">Ficha de transferencia</option>
                                @endif
                            </select>
                        </div> 
                    </div>
                    @if($documento->tipo_doc_id==='2')
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Certificado</label>
                            <input class="form-control modificar ingresado" type="text" readonly  name="gral[certificado]" id='gral_certificado' value="{{$documento->certificado or old('responsable')}}" placeholder="Certificado.."> </input>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha certificado</label>
                            <input class="form-control modificar ingresado" type="date" name="gral[fecha_certificado]"   id='gral_fecha_certificado'  readonly  value="{{($documento->fecha_certificado)?$documento->fecha_certificado->toDateString():''}}"> </input>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de registro:</label>
                            @if(isset($documento->fecha_registro))
                            <div class="col-md-11 row"><input class="form-control modificar ingresado" type="date"  name="gral[fecha_registro]"  value="{{$documento->fecha_registro->toDateString()}}"  id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%">
                              
                                     <a href="javascript:fecha_visible(1)" id="uncheck" style="font-size: 20px; color: #268a72; display: <?= (!$documento->fecha_registro_visible)?'block;':'none;';?>"> 
                                            <i class="glyphicon glyphicon-unchecked"></i>
                                        </a>


                                        <a href="javascript:fecha_visible(0)"   id="check" style="font-size: 20px; color: #268a72; display: <?= ( $documento->fecha_registro_visible)?'block;':'none;'; ?>">  
                                            <i class="glyphicon glyphicon-check" ></i>
                                        </a>
                               
                                       
                               
                            </div> 
                            <input type="hidden" name="gral[fecha_registro_visible]" value="{{$documento->fecha_registro_visible}}" id="fecha_registro_visible">






                            @else
                            <div class="col-md-11 row"><input class="form-control ingresado" type="date"  name="gral[fecha_registro]"   id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input type="checkbox" value='1' title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Año de inscripción</label>
                            <input class="form-control modificar sistema" type="text"  readonly  name="gral[inscripcion]" id="gral_inscripcion" value="{{$vigente->$relacion->inscripcion}}"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input class="form-control modificar sistema" type="text"   name="gral[nro_matricula]" readonly id="gral_nro_matricula" value="{{$documento->nro_matricula}}"> </input>
                        </div>
                    </div>
                    @if($documento->tipo_doc_id==='1')
                    <div class="col-md-3" id="grupo-objeto">
                        <div class="form-group">
                            <label>Objeto</label>
                             <select  id="objeto_id" class="form-control ingresado select-modificar" readonly onchange="$('#gral_objeto_id').val(this.value)">
                                    @foreach($objetos as $obj)
                                    <option value="{{$obj->id}}" <?= ($documento->objeto_id == $obj->id) ? 'selected' : '' ?>>{{$obj->descripcion}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control"  placeholder="Observaciones sobre el documento" name="gral[observaciones]">{{$documento->observaciones}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="form-inline"><label>Antecedentes </label><a href="javascript:agregar_antecedente()"><i class="glyphicon glyphicon-plus" style="margin-left: 4%"></i></a></div>                        
                    <div id="grupo_antecedente">
                        @foreach($documento->antecedentes as $key=>$ant)
                        <input type="text" value="{{$ant->nro_plano}}" placeholder="Nro plano antecedente" readonly  name="plano_ant[]" id="plano_ant_{{$key}}" class="form-control ingresado" style="margin-bottom: 6%">
        @endforeach 
    </div>
</div>    
</div>
<div class="col-md-8 col-md-offset-1 errores"></div>
        </div>
    </div>
</div>
