@extends('layout/admin')
@section('contenido')

<div class="box col-md-12">
    <div class="box-header">
        <h3>Listado de usuarios</h3>
    </div>    
    <div class="box-body">

        <table id="example1" class="table table-bordered table-striped dataTable">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>CUIT</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usr)
                <tr>
                    <td>{{$usr->nom_usuario}}</td>
                    <td>{{$usr->cuit}}</td>
                    <td>{{$usr->email}}</td>
                    <td>{{$usr->roles->pluck('nombre')->implode(' - ')}}</td>
                    <td>
                        <a href="{{URL('/usuario/edit',$usr->id)}}" class="btn btn-xs btn-info">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
</div>
@stop
