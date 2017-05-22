<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="realizar_pedido" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content danger">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title">Reliazar pedido</h4>
            </div>
            <div class="modal-body">

                <p id="mensaje_pedido">
                    El documento solicitado no se encuentra digitalizado. 
                    Si desea realizar el pedido de digiralización complete el siguiente formulario. 
                </p>
                <hr>

                {!!Form::open(['url'=>'pedido', 'method'=>'POST', 'autocomplete'=>'off', 'rules'=>'create','id'=>'form_pedido']) !!}



                <div id="field_tipo_doc" class="form-group">
                    <label for="tipo_doc" class="control-label">
                        Tipo de documento
                    </label>
                    <div class="controls">
                        <select name="tipo_doc" class="form-control" required>
                            <option value="">Seleccione tipo de documento</option>
                            <option value="1">Plano de mensura</option>
                            <option value="2">Ficha de transferencia</option>
                            <option value="3">Ambos</option>
                        </select>
                    </div>
                </div>
                <div id="field_nro_dpto" class="form-group">
                    <label for="nro_dpto" class="control-label">
                        Nro dpto
                    </label>
                    <div class="controls">
                        <input placeholder="Nro dpto" type="number" min="1" class="form-control" id="nro_dpto" required="required" name="nro_dpto">
                    </div>
                </div>
                <div id="field_nro_plano" class="form-group">
                    <label for="nro_plano" class="control-label">
                        Nro plano
                    </label>
                    <div class="controls">
                        <input placeholder="Nro plano" type="number" min="1"  class="form-control" id="nro_plano" required="required" name="nro_plano">
                    </div>
                </div>
                {!! Field::textarea('detalle_pedido',['placeholder'=>'Detalle','label'=>'Detalle','rows'=>'5']) !!}
                <button class="form-control btn btn-primary">
                    Enviar
                </button>
                <input type="reset" id="reset" style="display: none">
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
