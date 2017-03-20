@extends('layout/admin')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-heading"><h3 style="margin: 0px;">Nuevo usuario</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('cuit') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">CUIT</label>

                            <div class="col-md-6">
                                <input id="cuit" type="text" class="form-control" name="cuit" value="{{ old('cuit') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cuit') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6">
                                <input id="apellido" type="text" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre Usuario</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="nom_usuario" value="{{ old('nom_usuario') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom_usuario') }}</strong>
                                </span>
                                @endif
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

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Roles</label>
                            <div class="checkbox col-md-6">
                                @foreach($roles as $id=>$nombre)
                                <label>
                                    <input type="checkbox" name="roles[]" value="{{$id}}">
                                    {{$nombre}}
                                </label>

                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" id="persona_id" name="persona_id">
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
</div>
@endsection

@section('script')
<script>
    $('#cuit').change(function () {
        $.get('/getNyA/' + $(this).val(), function (NyA) {
            $('#nombre').val(NyA.apellido_y_nombre_padre);
            $('#apellido').val(NyA.razon_social);
            $('#persona_id').val(NyA.persona_id);
        })
    })
</script>
@endsection
