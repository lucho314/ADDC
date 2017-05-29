<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8 col-md-offset-1">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control" disabled type="text"name="gral[nro_dpto]"  value="{{$documento->nro_dpto or old('')}}" id="nro_dpto"> </input> </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control" disabled type="text"  name="gral[nro_plano]"  value="{{$documento->nro_plano or old('nombre')}}" id="nro_plano"> </input>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control" disabled type="text"  name="gral[nro_plano_hasta]" value="{{$documento->nro_plano_hasta or old('nombre')}}"  id='nro_plano_hasta'> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de partida:</label>
                            <input class="form-control" disabled type="text"  name="gral[nro_partida]" value="{{$documento->documentoSat[0]->nro_partida or old('nombre')}}" id="nro_partida"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de documento:</label>
                                <select class="form-control"   name="gral[tipo_doc_id]" id="gral_tipo_doc" disabled>
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
                   <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de registro:</label>
                            @if(isset($documento->fecha_registro))
                            <div class="col-md-11 row"><input class="form-control modificar" type="date"  name="gral[fecha_registro]" disabled  value="{{$documento->fecha_registro->toDateString()}}"  id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input value="1" type="checkbox" disabled <?= ($documento->fecha_registro_visible === '1') ? 'checked' : '' ?> title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @else
                            <div class="col-md-11 row"><input class="form-control" type="date"  name="gral[fecha_registro]"   id="gral_fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input type="checkbox" value='1' title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>
                            @endif

                        </div>
                    </div>
                     @if($documento->tipo_doc_id==='1')
                    <div class="col-md-3" id="grupo-objeto">
                        <div class="form-group">
                            <label>Objeto</label>
                             <select  id="objeto_id" class="form-control select-modificar" disabled onchange="$('#gral_objeto_id').val(this.value)">
                                    @foreach($objetos as $obj)
                                    <option value="{{$obj->id}}" <?= ($documento->objeto_id == $obj->id) ? 'selected' : '' ?>>{{$obj->descripcion}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    @endif


                    <input type="hidden" name="imponible" id="imponible">
                    <input type="hidden" name="gral[vigente]" value='0'>
                    </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control" placeholder="Observaciones sobre el documento" name="gral[observaciones]"></textarea>
                    </div>
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
