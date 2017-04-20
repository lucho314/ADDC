@extends('layout/admin')
@section('contenido')
<div class="box col-md-12"  style="margin-top: 20px;"> 
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Archivos para validar</h3>
    </div>
    <div class="box-body">
        <table class="table table-border table-striped table-responsive" id="pendientes">
            <thead>
                <tr>
                    <th>Tipo de documento</th>
                    <th>Nombre del documento</th>
                    <th>Fecha de alta</th>
                    <th>Usuario ultima modificacion</th>
                   <th>Accion</th>
                </tr>   
            </thead>
        </table>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        $('#pendientes').DataTable({
            "dom": 'lfrtip',
            "bDestroy": true,
            "processing": true,
            "serverSide": true,
            "ajax": "{{URL::action('DocumentoController@getListaDocumentos',['mio'=>$mio])}}",
            "columns": [
                {data: 'tipo.descripcion', name: 'tipo.descripcion'},
                {data: 'nombre', name: 'nombre'},
                {data: 'created_at', name: 'created_at',orderable: false},
                {data: 'usuario_ultima_mod', name: 'usuario_ultima_mod'},
                {data: 'accion', name: 'accion', orderable: false, searchable: false}
            ],

            "language": {
                "url": "/js/Spanish.json"
            }

        });



    })
</script>
@endsection