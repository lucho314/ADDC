<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro de eliminar este registro?</p>
                <form method="post" id="eliminar_registro">
                    <input type="hidden" name="id" id="id_registro_eliminar">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-ok">Eliminar</button>
            </div>
        </div>
    </div>
</div>
