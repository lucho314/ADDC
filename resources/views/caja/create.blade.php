@extends('layout/admin')
@section('contenido')

<div class="box col-md-12">

    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Nueva caja</h3>
    </div> 
    <div class="box-body">
        {!!Form::open(['url'=>'caja', 'method'=>'POST', 'id'=>'formulario_caja', 'autocomplete'=>'off', 'rules'=>'create']) !!}
        {{Form::token()}}
        <div class="container">
            <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-11">
                <label>Departamento</label>
                <select name="dpto" id="dpto" class="form-control" required="true">
                    <option value="">Seleccione Departamento</option>
                    @foreach($departamentos as $dpto)
                    <option value="{{$dpto->codigo_de}}">{{$dpto->departamento}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4 col-sm-11">
                <label>Número desde</label>
                <input type="number" class="form-control" name="numero_desde" readonly placeholder="Número desde.." id="numerodesde">
            </div>
            <div class="form-group col-md-4 col-sm-11">
                <label>Número hasta</label>
                <input type="number" class="form-control" name="numero_hasta" id="numerohasta"  placeholder="Número hasta.." required>
            </div>


            <div class="form-group col-md-4 col-sm-11">
                <label>Número de caja</label>
                <input type="number" class="form-control" name="numero_caja" readonly placeholder="Caja.." id="caja">
            </div>
            <div class="form-group col-md-4 col-sm-11">
                <label>Sector</label>
                <select class="form-control" name="sector" id="sector" required>
                    <option value="">Seleccione sector</option>
                    @foreach($sectores as $sec)
                    <option value="{{$sec->id}}">{{$sec->nro_sector}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4 col-sm-11">
                <label>Módulo</label>
                <select class="form-control" name="modulo" id="modulo" required>
                    <option value="">Seleccione modulo</option>
                </select>
            </div>
            <div class="form-group col-md-4 col-sm-11">
                <label>Estante</label>
                <input type="number" class="form-control" name="estante" id="estante"  readonly placeholder="Estante..">
            </div>

            <div class="form-group col-md-4 col-sm-11 ">
                <label>Posición</label>
                <input type="number" class="form-control" name="posicion" id="posicion" readonly placeholder="Posicion..">
            </div>


            <div class="form-group col-md-4 col-sm-11">
                <label>Profundidad</label>
                <input type="number" class="form-control" name="profundidad" id="profundidad" readonly placeholder="Profundidad..">
            </div>


            <div class="col-md-12 col-sm-11">
                <div style="float: right">
                    <input type="submit" class="btn btn-success" value="Aceptar" >
                    <input type="reset" class="btn btn-danger" value="Cancelar">
                </div>
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>
@endsection
@section('script')
@endsection