<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="seleccion-partidas-modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog">
        <div class="modal-content danger">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title">Ingrese partida</h4>
            </div>
            <div class="modal-body">

                <table class="table table-border table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Partida</th>
                            <th>Sup Terreno</th>
                            <th>Sup Edificada</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-seleccion-partidas">

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"> Cerrar</button>
                <button class="btn btn-primary"  type="button" id="definirPartidas">Confirmar</button>
            </div>

        </div>
    </div>
</div>
