

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

var tablePendiente = $('#pedidos_pendientes').DataTable({

    "dom": 'Blfrtip',
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
    /*columnDefs: [{
     targets: 0,
     visible: false
     }],*/
    "bDestroy": true,
    "processing": true,
    "serverSide": true,
    "ajax": '/pedido/listado_pendiente',
    "columns": [
        {data: 'id', name: 'id'},
        {data: 'tipo_doc',

            render: function (data, type, row) {
                return getTipoDocumento(data);
            },

            name: 'tipo_doc'},
        {data: 'nro_dpto', name: 'nro_dpto'},
        {data: 'nro_plano', name: 'nro_plano'},
        {data: 'detalle_pedido', name: 'detalle_pedido'},
        {data: 'usuario_pidio.nombre', name: 'usuarioPidio.nombre'},
        {data: 'fecha_pedido', name: 'fecha_pedido'},
        {data: 'desAv', name: 'desAv', orderable: false, searchable: false},
        {data: 'acciones', name: 'acciones', orderable: false, searchable: false, width: "10%"}
    ],

    "language": {
        "url": "/js/Spanish.json"
    }
});



var tableTerminado = $('#pedidos_terminados').DataTable({

    "dom": 'lfrtip',
    "bDestroy": true,
    "processing": true,
    "serverSide": true,
    "ajax": '/pedido/listado_terminados',
    "columns": [
        {data: 'tipo_doc',

            render: function (data, type, row) {
                return getTipoDocumento(data);
            },

            name: 'tipo_doc'},
        {data: 'nro_dpto', name: 'nro_dpto'},
        {data: 'nro_plano', name: 'nro_plano'},
        {data: 'detalle_pedido', name: 'detalle_pedido'},
        {data: 'usuario_pidio.nombre', name: 'usuarioPidio.nombre'},
        {data: 'fecha_pedido', name: 'fecha_pedido'},
        {data: 'fecha_terminado', name: 'fecha_terminado'},
        {data: 'usuario_atendio.nombre', name: 'usuarioAtendio.nombre'},
        {data: 'observaciones', name: 'observaciones'}
    ],

    "language": {
        "url": "/js/Spanish.json"
    }
});















$('#pedidos_pendientes tbody').on('click', '.fa.fa-check-square', function () {
    var data = tablePendiente.row($(this).parents('tr')).data();
    terminarPedido(data.id);
});


$('#pedidos_pendientes tbody').on('click', '.fa.fa-warning', function () {
    var data = tablePendiente.row($(this).parents('tr')).data();
    $('#detalle_terminado #nro_dpto').val(data.nro_dpto);
    $('#detalle_terminado #nro_plano').val(data.nro_plano);
    $('#detalle_terminado .id').val(data.id).text(data.id);
    $('#detalle_terminado #tipo_doc').val(getTipoDocumento(data.tipo_doc));
    $('#detalle_terminado').modal('toggle');
});



//ELIMINAR.
$('#pedidos_pendientes tbody').on('click', '.fa.fa-times-circle', function () {
    var data = tablePendiente.row($(this).parents('tr')).data();


    swal({
        title: "Está seguro?",
        text: "Esta acción eliminará el pedido seleccionado",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Eliminar',
        cancelButtonText: "Cancelar",
        closeOnCancel: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
            function () {

                $.post('/pedido/' + data.id, {"_method": "DELETE", '_token': $("input[name='_token']").val()}, function (data) {
                    if (data.respuesta) {
                        swal("Eliminado!", "Se elimino el pedido correctamente!", "success");
                        $('#pedidos_pendientes').dataTable()._fnAjaxUpdate();
                    } else {
                        swal("Error!", "Surgió un error al eliminar el pedido,intente nuevamente!", "error");
                    }
                });
            });
});




$('#form_detalle_terminado').submit(function (e) {
    e.preventDefault();
    var id = $('#pedido_id').val();
    var descripcion = $('#descripcion').val();
    $('#descripcion').val('');
    terminarPedido(id, descripcion);
    $('#detalle_terminado').modal('toggle');

});


function terminarPedido(id, descripcion = null) {
    $.get('/pedido/terminado', {'id': id, 'observaciones': descripcion}, function (data) {
        if (data.respuesta) {
            swal("Finalizado!", "Se finalizo el pedido correctamente!", "success");

            $('#pedidos_pendientes').dataTable()._fnAjaxUpdate();


        } else {
            swal("Error!", "Surgió un error al finalizar el pedido,intente nuevamente!", "error");
        }
    });
}
;






function getTipoDocumento(data) {
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

}
;

