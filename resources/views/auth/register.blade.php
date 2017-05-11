@extends('layout/admin')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-heading"><h3 style="margin: 0px;">Nuevo usuario</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" id="nuevoUser" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('cuit') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Empleado</label>

                            <div class="col-md-6">
                                <select name="nom_usuario" class="js-example-basic-single form-control" id="empleado">
                                    <option value="">Seleccione Empleado</option>
                                    @foreach($usuarios as $usr)
                                    <option value="{{$usr->cn[0]}}">{{$usr->displayname[0]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Usuario</label>

                            <div class="col-md-6">
                                <input id="usuario" type="text" class="form-control" disabled="true">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('area_id') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Área</label>

                            <div class="col-md-6">
                                <select name="area_id" class="form-control" required>
                                    <option value="">Seleccione area</option>
                                    @foreach($areas as $area)
                                    <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Roles" class="col-md-4 control-label">Roles</label>
                            <div class="checkbox col-md-6">
                                @foreach($roles as $id=>$nombre)
                                <label>
                                    <input type="checkbox" name="roles[]" value="{{$id}}">
                                    {{$nombre}}
                                </label>

                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="nombre" id="nombre">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="cargando" class="col-md-12 text-center" style="display: none">
        <img src="{{asset('img/cargando.gif')}}" >
        <div class="text-center">Espere...</div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#empleado').change(function () {
        $('#nuevoUser').css('opacity', '0.3');
        $('#cargando').show();
        $('#nombre').val($('#empleado option:selected').text());
        var cn = $(this).val();
        $.get('/usuario/get_usuario_correo', {'cn': cn}, function (data) {
            $('#usuario').val(cn);
            $('#email').val(data.mail[0]);
            $('#cargando').hide();
            $('#nuevoUser').css('opacity', '1');

        });
    });
</script>
@endsection
