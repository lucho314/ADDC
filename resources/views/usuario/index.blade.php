@extends('layout/admin')
@section('contenido')

<div class="box col-md-12">
    <div class="box-header">
        <h3>Listado de usuarios</h3>
    </div>    
    <div class="box-body">
        <div class="col-lg-10 col-md-offset-1">
            <table id="example1" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Apellido y Nombre</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Área</th>
                        <th>Roles</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usr)
                    <tr>
                        <td>{{$usr->nombre}}</td>
                        <td>{{$usr->nom_usuario}}</td>
                        <td>{{$usr->email}}</td>
                        <td>{{$usr->area->descripcion or ''}}</td>
                        <td>{{$usr->roles->pluck('nombre')->implode(' - ')}}</td>
                        <td>
                            <a href="javascript:openRoles({{$usr->id}},'{{$usr->nombre}}')" class="btn btn-sm btn-info">Roles</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>

        @include('usuario.modal_roles')


    </div>
</div>
@stop
@section('script')
<script>
    function openRoles(id, nom_usu) {
        $('#header_modal h4').html('Editar usuario: '+ nom_usu);

        $.get('/usuario_roles', {'id': id}, function (data) {
            console.log(data);
            var roles = data.roles;
            $('#area_id').val(data.usuario.area_id);
            $(':checkbox').each(function (i, val) {
                if (typeof (roles[$(this).attr('id')]) !== 'undefined')
                    $(this).prop('checked', true);
                else
                    $(this).prop('checked', false);
            });
            $('#id').val(id);
            $('#modal_roles').modal('toggle');
        });

    }

    $('#modificar_roles').submit(function (e) {
        e.preventDefault();
        var ruta = '/usuario/' + $('#id').val();
        var datos = $(this).serialize();
        $.post(ruta, datos, function (data) {

            swal("Editado!", "El usuario se modificó satisfactoriamente!", "success");
            //
        }, 'json').fail(function () {
            swal("Error!", "Se produjo un error al modificar el usuario!", "error");
        });
        $('#modal_roles').modal('toggle');

    })


    $(document).on('click', '.confirm', function () {
        location.reload();
    })
</script>
@stop