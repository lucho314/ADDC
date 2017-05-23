

function abrir_modal_pedido() {
    $('#mensaje_pedido').hide();
    $('#realizar_pedido').modal('toggle');

}


$('#form_pedido').submit(function (e) {
    e.preventDefault();

    var datos = $(this).serialize();
    var url = $(this).attr('action');

    $.post(url, datos, function (data) {
        if (data.respuesta) {
            swal("Realizado!", "El pedido se registró correctamente!", "success");
            $('#realizar_pedido').modal('toggle');
            $('#reset').click();
        } else {
            swal("Error!", "Surgió un error al cargar la solicitud,intente nuevamente!", "error");
        }
        ;
    }).fail(function (data) {
        swal("Error!", "Surgió un error al cargar la solicitud,intente nuevamente!", "error");
    });
});

$('#pedidos_pendientes').DataTable({

    "dom": 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            exportOptions: {
                columns: ':visible'
            },
            customize: function (win) {
                $(win.document.body)
                        .css('font-size', '8pt');


                $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
            }
        },
        'colvis'
    ],
    columnDefs: [{
            targets: 0,
            visible: false
        }],
    "bDestroy": true,
    "processing": true,
    "serverSide": true,
    "ajax": '/pedido/listado_pendiente',
    "columns": [
        {data: 'id', name: 'id'},
        {data: 'tipo_doc',

            render: function (data, type, row) {
                switch (data) {
                    case '1' :
                        return 'Plano de mensura';
                        break;
                    case '2' :
                        return 'Ficha de transferencia';
                        break;
                    default :
                        return 'Ficha y Plano';
                        break;
                }
            },

            name: 'tipo_doc'},
        {data: 'nro_dpto', name: 'nro_dpto'},
        {data: 'nro_plano', name: 'nro_plano'},
        {data: 'detalle_pedido', name: 'detalle_pedido'},
        {data: 'usuario_pidio.nombre', name: 'usuarioPidio.nombre'},
        {data: 'fecha_pedido', name: 'fecha_pedido'},
        {data: 'desAv', name: 'desAv', orderable: false, searchable: false},
        {data: 'acciones', name: 'acciones', orderable: false, searchable: false}
    ],

    "language": {
        "url": "/js/Spanish.json"
    }



})

