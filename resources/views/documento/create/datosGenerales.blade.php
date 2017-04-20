<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
            <div class="col-md-8 col-md-offset-1">
                <div  id="datosGenerales">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control" type="text"  name="gral[nro_dpto]" id="gral_nro_dpto"  value="{{$documento->nro_dpto or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control" type="text"   name="gral[nro_plano]" id="gral_nro_plano"  value="{{$documento->nro_plano or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control" type="text"   name="gral[nro_plano_hasta]" id="gral_nro_plano_hasta"  value="{{$documento->nro_plano_hasta or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de documento:</label>
                            <select class="form-control"  name="gral[tipo_doc_id]" id="gral_tipo_doc">
                                <option value="1">Plano de mensura</option>
                                <option value="2">Ficha de transferencia</option>
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-3" id="grupo_certificado">
                        <div class="form-group">
                            <label>Certificado</label>
                            <input class="form-control modificar" type="text"  name="gral[certificado]" id='gral_certificado' placeholder="Certificado.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de registro:</label>
                            <div class="col-md-11 row"><input class="form-control" type="date"  name="gral[fecha_registro]"   id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input type="checkbox" value='1' title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Año de inscripción</label>
                            <input class="form-control modificar" type="text" readonly  name="gral[inscripcion]" id="gral_inscripcion" value="{{$documento->temporal[0]->inscripcion or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Matrícula</label>
                            <input class="form-control modificar" type="text"   name="gral[nro_matricula]" readonly id="gral_nro_matricula" value="{{$documento->temporal[0]->nro_matricula or old('nombre')}}" placeholder="Codigo de producto.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Responsable</label>
                            <input class="form-control" type="text"   name="gral[responsable]" id="gral_responsable" value="{{$documento->responsable or old('responsable')}}" placeholder="Responsable.."> </input>
                        </div>
                    </div>

                    <div class="col-md-3" id="grupo_objeto">
                        <div class="form-group">
                            <label>Objeto</label>
                            <select class="form-control"  name="gral[objeto_id]" id="gral_objeto_id">
                                <option value="">Seleccione Objeto</option>
                                @foreach($objetos as $obj)
                                <option value="{{$obj->id}}">{{$obj->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Perito</label>
                            <input class="form-control" type="text" name="gral[perito]" id="gral_perito"  placeholder="Perito..."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Gestor</label>
                            <input class="form-control" type="text" name="gral[gestor]" id="gral_gestor"  placeholder="Gestor.."> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Corrector</label>
                            <input class="form-control" type="text" name="gral[corrector]" id="gral_corrector" placeholder="Corrector.."> </input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="form-inline"><label>Antecedentes </label><a href="javascript:agregar_antecedente()"><i class="glyphicon glyphicon-plus" style="margin-left: 4%"></i></a></div>                        
                    <div id="grupo_antecedente">
                        <input type="number" placeholder="Nro plano antecedente"  name="plano_ant[]" id="plano_ant_0" class="form-control" style="margin-bottom: 6%">
                    </div>

                </div>    

            </div>
        </div>
            <div class="col-md-8 col-md-offset-1 errores"></div>
        </div>
    </div>
</div>
