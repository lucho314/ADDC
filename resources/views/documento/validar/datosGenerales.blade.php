<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8 col-md-offset-1">
                <div  id="datosGenerales">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control ingresado" type="text"  name="gral[nro_dpto]" id="gral_nro_dpto" required="required" readonly value="{{$documento->nro_dpto or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control ingresado" type="text"   name="gral[nro_plano]" id="gral_nro_plano" required="required" readonly value="{{$documento->nro_plano or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control ingresado" type="text"   name="gral[nro_plano_hasta]" id="gral_nro_plano_hasta" required="required" readonly value="{{$documento->nro_plano_hasta or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de documento:</label>

                            <select class="form-control ingresado"  name="gral[tipo_doc]" id="gral_tipo_doc" readonly>
                                @if($documento->tipo_doc!='')
                                <option value="1" <?= ($documento->tipo_doc === '1') ? 'selected' : ''; ?>>Plano de mensura</option>
                                <option value="2" <?= ($documento->tipo_doc === '2') ? 'selected' : ''; ?> >Ficha de transferencia</option>
                                @else
                                <option value="1">Plano de mensura</option>
                                <option value="2">Ficha de transferencia</option>
                                @endif
                            </select>
                        </div> 
                    </div>
                    @if($documento->tipo_doc==='2')
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Certificado</label>
                            <input class="form-control modificar sistema" type="text" readonly  name="gral[certificado]" id='gral_certificado' value="{{$documento->certificado or old('responsable')}}" placeholder="Certificado.."> </input>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de registro:</label>
                            @if(isset($documento->fecha_registro))
                            <div class="col-md-11 row"><input class="form-control modificar sistema" type="date"  name="gral[fecha_registro]"  value="{{$documento->fecha_registro->toDateString()}}"  id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input value="1" type="checkbox" <?= ($documento->fecha_registro_visible==='1')? 'checked':'' ?> title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @else
                            <div class="col-md-11 row"><input class="form-control" type="date"  name="gral[fecha_registro]"   id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input type="checkbox" value='1' title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Año de inscripción</label>
                            <input class="form-control modificar sistema" type="text"  readonly  name="gral[inscripcion]" id="gral_inscripcion" value="{{$documento->temporal[0]->inscripcion or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input class="form-control modificar sistema" type="text"   name="gral[nro_matricula]" readonly id="gral_matricula" value="{{$documento->temporal[0]->nro_matricula or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Responsable</label>
                            <input class="form-control ingresado" type="text" readonly  required  name="gral[responsable]" id="gral_responsable" value="{{$documento->responsable or old('responsable')}}" placeholder="Responsable.."> </input>
                        </div>
                    </div>

                    @if($documento->tipo_doc==='1')
                    <div class="col-md-3" id="grupo-objeto">
                        <div class="form-group">
                            <label>Objeto</label>
                            @if(strpos($documento->objeto_id, '*'))

                            <select  id="objeto_id" class="form-control ingresado select-modificar" style="border: solid 2px #f97a7a;background-color: #f9dede;" readonly onchange="$('#gral_objeto_id').val(this.value)">
                                @else
                                <select  id="objeto_id" class="form-control ingresado select-modificar" readonly onchange="$('#gral_objeto_id').val(this.value)">
                                    @endif
                                    @foreach($objetos as $obj)
                                    <option value="{{$obj->id}}" <?= ($documento->objeto_id == $obj->id) ? 'selected' : '' ?>>{{$obj->descripcion}}</option>
                                    @endforeach
                            </select>
                            <input type="hidden" name="gral[objeto_id]" id="gral_objeto_id" value="{{$documento->objeto_id}}">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Perito</label>
                            <input class="form-control modificar sistema" type="text" readonly name="gral[perito]" id="gral_perito" value="{{$documento->perito or old('perito')}}" placeholder="Perito..."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Gestor</label>
                            <input class="form-control modificar sistema" type="text" readonly name="gral[gestor]" id="gral_gestor" value="{{$documento->gestor or old('gestor')}}" placeholder="Gestor.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Corrector</label>
                            <input class="form-control modificar sistema" type="text" readonly name="gral[corrector]" id="gral_corrector" value="{{$documento->corrector or old('corrector')}}" placeholder="Corrector.."> </input>
                        </div>
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
