<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8 col-md-offset-1">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro Departamento:</label>
                            <input class="form-control" type="text"name="gral[nro_dpto]"  required="required" id="nro_dpto"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano desde:</label>
                            <input class="form-control" type="text"  name="gral[nro_plano]"  required="required" id="nro_plano"> </input>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de plano hasta:</label>
                            <input class="form-control" type="text"  name="gral[nro_plano_hasta]"  required="required" id='nro_plano_hasta'> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nro de partida:</label>
                            <input class="form-control" type="text"  name="gral[nro_partida]"  required="required" id="nro_partida"> </input>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de documento:</label>
                            <select class="form-control"  name="gral[tipo_doc_id]" id="tipo_doc">
                                <option value="1">Plano de mensura</option>
                                <option value="2">Ficha de transferencia</option>
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de registro:</label>
                            <div class="col-md-11 row"><input class="form-control" type="date"  name="gral[fecha_registro]"   id="fecha_registro"></div>
                            <div class="col-md-1" style="margin-top: 3%"><input type="checkbox" value='1' title="Fecha visible" name="gral[fecha_registro_visible]"   id="gral_fecha_registro_visible"></div>

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


                    <input type="hidden" name="imponible" id="imponible">
                    <input type="hidden" name="gral[vigente]" value='0'>
                    <input type="hidden" name="gral[estado_id]" value="2" id="imponible">
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
                    <div class="form-inline"><label>Antecedentes </label><a href="javascript:agregar_antecedente()"><i class="glyphicon glyphicon-plus" style="margin-left: 4%"></i></a></div>                        
                    <div id="grupo_antecedente">
                        <input type="number" placeholder="Nro plano antecedente"  name="plano_ant[]" id="plano_ant_0" class="form-control" style="margin-bottom: 6%">
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>
