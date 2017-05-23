@extends('layout/admin')
@section('contenido')
<div class="box">
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Pedidos pendientes</h3>
    </div> 
    <div class="box-body">
        <table class="table table-responsive table-striped table-border table-condensed table-hover" id="pedidos_pendientes">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo documento</th>
                    <th>Num Dto</th>
                    <th>Num Plano</th>
                    <th>Detalle</th>
                    <th>Solicitado por</th>
                    <th>Fecha solicitud</th>
                    <th>Descripción avanzada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection

