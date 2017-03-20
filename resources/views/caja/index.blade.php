@extends('layout/admin')
@section('contenido')
<div class="box">  
    <div class="box-header">
        <h3>Busqueda</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12 form-inline text-center busqueda" >
            <form id="busquedaCaja" action="#">
                <div class="form-group campos">
                    <label>Departamento:</label>
                    <select class="form-control" name="dpto" id="dpto" required="">
                        @foreach($dptos as $dpto)
                        <option value="{{$dpto->codigo_de}}">{{$dpto->departamento}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group campos">
                    <label>Plano desde:</label>
                    <input class="form-control" type="text" name="numero_desde" required placeholder="Plano desde..."> </input>
                </div>
                <div class="form-group campos">
                    <label>Plano hasta:</label>
                    <input class="form-control" type="text" name="numero_hasta" placeholder="Plano hasta..."> </input>
                </div>
                <div class="form-group campos">
                    <button class="btn btn-success" type="submit">Buscar</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="box">

    <div class="box-header">
        <h3>Listado de cajas</h3>
    </div>
    <div class="box-body">
        <div class="box col-md-12">  
            <table class="table table-responsive table-striped table-border table-condensed table-hover" id="tabla-caja">
                <thead>
                    <tr>
                        <th>Numero Caja</th>
                        <th>Tipo documento</th>
                        <th>Num Dpto</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Sector</th>
                        <th>Módulo</th>
                        <th>Estante</th>
                        <th>Posicion</th>
                        <th>Profundidad</th>
                        <th></th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>

</div>
@endsection




