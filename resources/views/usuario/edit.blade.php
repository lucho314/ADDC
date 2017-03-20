@extends('layout/admin')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-heading"><h3 style="margin: 0px;">Editar usuario</h3></div>
                <div class="panel-body">
                    {!!Form::model($usuario, ['action' => ['UsuarioController@update', $usuario->id], 'method'=>'PATCH','class'=>"form-horizontal"]) !!}
                    {{Form::token()}}


                    <div class="form-group{{ $errors->has('cuit') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">CUIT</label>

                        <div class="col-md-6">
                            <input id="cuit" type="text" class="form-control"  value="{{ $usuario->cuit }} " disabled>

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
                            <input id="name" type="text" class="form-control" name="nom_usuario" value="{{ $usuario->nom_usuario}}" required autofocus>

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
                            <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    @can('roles', $usuario)
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Roles</label>
                            <div class="checkbox col-md-6">
                                @foreach($roles as $id=>$nombre)
                                <label>
                                    <input type="checkbox" name="roles[]" value="{{$id}}" <?= ($usuario->roles->pluck('id')->contains($id))? 'checked' : ''?>>
                                    {{$nombre}}
                                </label>

                                @endforeach
                            </div>
                        </div>
                    @endcan
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
      $(function (){
        $.get('/getNyA/' + $('#cuit').val(), function (NyA) {
            $('#nombre').val(NyA.apellido_y_nombre_padre);
            $('#apellido').val(NyA.razon_social);
        })
    });

</script>
@endsection