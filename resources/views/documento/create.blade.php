@extends('layout/admin')
@section('contenido')

<div class="row">
    <div class="col-md-12 col-xs-12 ">
        @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li> {{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>


    {!!Form::open(['url'=>(Request::is('documento/validar/*'))?'documento/validado':'documento/editado', 'method'=>'POST', 'autocomplete'=>'off','files'=>'true', 'rules'=>'create', 'id'=>'form_validar']) !!}
    {{Form::token()}}

    <div>
        <div class="col-md-12 container-fluid">
            <object style="width:100%;" id="objeto_imagen" type="application/pdf"  data="{{URL::action('DocumentoController@show',$documento->id)}}"></object>
        </div>
        <ul class="tab">
            <div class="col-md-8">
                <div class="col-md-10">
                <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(0, 'generales')">Datos Generales</a></li>
                @if($documento->hasVigente())
                    <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'partidas')">Partidas y Superficies</a></li>
                    <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(2, 'ubicacion')">Ubicación Geográfica</a></li>
                    <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(4, 'incidencias')">Incidencias</a></li>
                @endif
                </div>
                <div class="col-md-1">
                    <a href="javascript:ocultar()" id="minimizar"  style="float: left;position: relative; left:25%; color: black"><i class="glyphicon glyphicon-chevron-down" aria-hidden="true"></i></a>
                    <a href="javascript:desocultar()" id="maximizar"  style="display: none; position: relative; float: left; left:25%; color: black"><i class="glyphicon glyphicon-chevron-up" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-4" >
            @if(Request::is('documento/validar/*'))
                <div class="col-md-5">
                    <div class="form-inline row" style="margin-top: 2%">
                        <label style="padding-right: 2%">ESTADO</label>

                        <select class="form-control" name="gral[estado_id]" id="estado">
                            @if(auth()->user()->isValidador())
                            <option value="1">Activo</option>
                            <option value="3">Derivar</option>
                            @elseif(auth()->user()->isAdmin())  
                            <option value="1">Activo</option>
                            <option value="3">Derivar</option>
                            @else
                            <option value="2">Confirmar</option>
                            @endif
                        </select>
                    </div>
                </div>
                @include('documento.validar.derivar')
            @endif
                <div class="form-inline col-md-<?=(Request::is('documento/validar/*'))?'7':'12'?>"  style="margin-top: 2%;">
                    <div style=" float: right">
                            <a href="{{ URL::previous() }}"  class="btn btn-danger">Cancelar</a>
                            <button class="btn btn-success" id="submit">Aceptar</button>
                    </div>
                </div>
            </div>
            
        </ul>
        @if($documento->hasVigente())
        <div id="generales" class="tabcontent  datos_tabcontent" style="display: block">
            @include('documento.validar.datosGenerales')
        </div>
        <div id="partidas" class="tabcontent datos_tabcontent">
            @include('documento.validar.datosPartidas')

        </div>
        <div id="ubicacion" class="tabcontent datos_tabcontent">
            @include('documento.validar.datosUbicacion')
        </div>
        <div id="incidencias" class="tabcontent datos_tabcontent">
            @include('documento.validar.incidencias')
        </div>
        @else 
        <div id="generales" class="tabcontent  datos_tabcontent" style="display: block">
            @include('documento.validar.cargaAntecedente')
        </div>
        @endif
        <input type="hidden"  value="0" id="biss" name="gral[bis]">
        <input type="hidden" name="gral[id]" id="documento_id" value="{{$documento->id}}">
        <input type="submit" id="enviar" style="display: none">
       
  
        {{Form::close()}}
    </div>

</div>
@include('documento.validar.modal_eliminar')
@endsection
@section('script')
@include('vendor.lrgt.ajax_script', ['form' => '#form_validar',
'request'=>'App/Http/Requests/DocumentoFormRequest','on_start'=>false])
<script>
    $('#objeto_imagen').css('height', mitadAlto);
</script>
@include('documento.parcial.cambiar_seccion');
@endsection