<div class="container-fluid" >
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-8 col-md-offset-1">
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
                <input type="hidden" name="imponible" id="imponible">
                <input type="hidden" name="gral[vigente]" value='0'>
                <input type="hidden" name="gral[estado_id]" value="2" id="imponible">
                
            </div>
        </div>
    </div>
</div>
