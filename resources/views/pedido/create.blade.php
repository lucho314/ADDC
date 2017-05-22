@extends('layout/admin')
@section('contenido')
<div class="box">
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Busquedas</h3>
    </div> 
    <div class="box-body">
    {!!Form::open(['url'=>'pedido', 'method'=>'POST', 'autocomplete'=>'off', 'rules'=>'create']) !!}
	    <input type="text" name="tipo_doc" class="form-control" placeholder="tipo doc">
	    <input type="text" name="nro_dpto" class="form-control" placeholder="Nro dpto">
	    <input type="text" name="nro_plano" class="form-control" placeholder="nro plano">
	    <input type="text" name="detalle_pedido" class="form-control" placeholder="detalle">
	    <button class="form-control">
	    	Enviar
	    </button>
	  {{Form::close()}}
    </div>
</div>
@endsection