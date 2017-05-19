var modulos;
var nro_modulo;
var capacidad;
$('#sector').change(function () {
    var nroSector = $(this).val();
    $.get('/caja/modulos_disponibles', {sector: nroSector}, function (data) {
        console.log(data);
        modulos = data;
        $('#modulo').html('<option value="">Seleccione modulo</option>');
        $.each(data, function (i, value) {
            $('#modulo').append('<option value="' + value.nro_modulo + '">' + value.nro_modulo + '</option>');
        });
    }, 'json');
})


$('#modulo').change(function () {
    var modulo = $(this).val();
    $.each(modulos, function (i, v) {
        console.log(v.nro_modulo);
        if (v.nro_modulo == modulo)
        {
            capacidad = v.capacidad;
            nro_modulo = v.nro_modulo;
            return false;
        }
    });
    $.get('/caja/estantes_disponibles', {modulo: nro_modulo, capacidad: capacidad, sector: $('#sector').val()}, function (data) {
        console.log(data);
        $('#estante').val(data.estante);
        $('#posicion').val(data.posicion);
        $('#profundidad').val(data.profundidad);

    }, 'json').fail(function () {
        $('#estante').val(1);
        $('#posicion').val(1);
        $('#profundidad').val(1);
    });

});

$('#dpto').change(function () {
    $.get('/caja/get_caja', {dpto: $(this).val()}, function (data) {
        $('#caja').val(parseInt(data.numero_caja) + 1);
        $('#numerodesde').val(parseInt(data.contenidos) + 1);
    }, 'json');
});


$('#numerohasta').change(function () {
    comprobarNumeroHasta();
})

function comprobarNumeroHasta() {
    if ($('#numerohasta').val() < $('#numerodesde').val()) {
        sweetAlert("Atención!", "Número hasta debe ser mayor a Número desde!", "warning");
        return false;
    }
}

$('#formulario_caja').submit(function () {
    return comprobarNumeroHasta();
})


function eliminar_caja(id)
{
    swal({
        title: "Está seguro?",
        text: "Esta acción eliminará la caja seleccionada",
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
                $.get('/caja/eliminar', {'id': id}, function (data) {
                    if (data.Error) {
                       swal("Eliminado!", "Registro eliminado correctamente!", "success");
                       $('#tabla-caja').dataTable()._fnAjaxUpdate();
                    } else {

                        swal("No eliminado!",'Intente nuevamente', "error");
                    }
                }, 'JSON');
            });
}


$('#busquedaCaja').submit(function (e) {
    e.preventDefault();
    var datos = $(this).serialize();

    $('#tabla-caja').DataTable({
        "dom": 'Brtip',
        buttons: [
             'pdf', 'print'
        ],
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": '/caja/listar?' + datos,
        "columns": [
            {data: 'numero_caja', name: 'numero_caja'},
            {data: 'tipo_doc', name: 'tipo_doc'},
            {data: 'dpto', name: 'dpto'},
            {data: 'contenidos.numero_desde', name: 'numero_desde', orderable: false, searchable: false},
            {data: 'contenidos.numero_hasta', name: 'contenidos.numero_hasta', orderable: false, searchable: false},
            {data: 'sector', name: 'sector'},
            {data: 'modulo', name: 'modulo'},
            {data: 'estante', name: 'estante'},
            {data: 'posicion', name: 'posicion'},
            {data: 'profundidad', name: 'profundidad'},
            {data: 'accion', name: 'accion', orderable: false, searchable: false}
        ],

        "language": {
            "url": "/js/Spanish.json"
        }
    });

});

    function handleAjaxErrorLoc( xhr, textStatus, error ) {

        $.each(error,function(i,t){
            console.log(i);
        });

        }