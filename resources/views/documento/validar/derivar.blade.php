<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="derivar_doc_modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog">
        <div class="modal-content danger">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title">Derivar</h4>
            </div>
            <div class="modal-body">
                @if(!auth()->user()->isCorrector())
                    <div class="form-group">
                        <label>&Aacute;rea</label>
                        <select name="area_id" class="form-control">
                            @foreach($areas as $a)
                            <option value="{{$a->id}}">{{$a->descripcion}}</option>
                            @endforeach
                        </select>

                    </div>
                @endif
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="gral[observacion]" class="form-control" id="observacion"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"> Cerrar</button>
                <button class="btn btn-primary"  type="submit" id="aceptar_derivado">Confirmar</button>
            </div>

        </div> 
    </div>
</div>

