@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3 col-md-offset-1 text-center">
            <div>
                <img src="/img/Escudo.gif"><br><br>
                <b>DIRECCIÓN DE CATASTRO</b><br>
                <b>provincia de Entre Ríos</b>
            </div>
        </div>
        <div class="col-md-6">
            
            <div class="panel panel-primary" style="border-color: #125d3c;">
                <div class="panel-heading" style="background-color: #268a72;
    border-color: #125d3c;">Iniciar sesión</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                            <label for="email" class="control-label">Nombre de Usuario</label>

                           
                                <input id="nom_usuario" type="text" placeholder="Nombre de usuario" class="form-control" name="nom_usuario" value="{{ old('nom_usuario') }}" required autofocus>

                                @if ($errors->has('nom_usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nom_usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                            <label for="password" class="control-label">Contraseña</label>

                                <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}} > Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
