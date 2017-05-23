<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="detalle_terminado" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content danger">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title">Finalizar pedido N° <span class="id"></span> </h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form_detalle_terminado">
                    <input type="hidden" class="id" id="pedido_id">
                    {!! Field::text('nro_dpto',['disabled','id'=>'nro_dpto']) !!}
                    {!! Field::text('nro_plano',['disabled','id'=>'nro_plano']) !!}
                    {!! Field::text('tipo_documento',['disabled','id'=>'tipo_doc']) !!}
                    <div id="field_nro_plano" class="form-group">
                        <label for="nro_plano" class="control-label">
                            Descripcion
                        </label>
                        <div class="controls">
                            <textarea class="form-control" id="descripcion" required></textarea>
                        </div>
                    </div>
                    <button class="form-control btn btn-primary" type="submit">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>