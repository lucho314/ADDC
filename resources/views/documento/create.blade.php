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


    {!!Form::open(['url'=>'documento/validado', 'method'=>'POST', 'autocomplete'=>'off','files'=>'true', 'rules'=>'create', 'id'=>'form_validar']) !!}
    {{Form::token()}}

    <div>
        <div class="col-md-12 container-fluid">
            <object style="width:100%;height:500px;" type="application/pdf"  data="{{URL::action('DocumentoController@show',$documento->id)}}"></object>
        </div>
        <ul class="tab">
            <div class="col-md-7">
                <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(0, 'generales')">Datos Generales</a></li>
                <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'partidas')">Partidas y Superficies</a></li>
                <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(2, 'ubicacion')">Ubicación Geográfica</a></li>
                <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(4, 'incidencias')">Incidencias</a></li>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-2" >
                <div class="form-inline" style="margin-top: 3%; float: right">
                    <a href="{{ URL::previous() }}"  class="btn btn-danger">Cancelar</a>
                    <button class="btn btn-success" id="submit">Aceptar</button>
                </div>
            </div>

        </ul>
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
        <input type="hidden"  value="0" id="biss" name="gral[bis]">
        <input type="hidden" name="gral[id]" id="documento_id" value="{{$documento->id}}">
        <input type="submit" id="enviar" style="display: none">
        @include('documento.validar.derivar')
        {{Form::close()}}
    </div>

</div>
 @include('documento.validar.modal_eliminar')
@endsection
@section('script')
@include('vendor.lrgt.ajax_script', ['form' => '#form_validar',
'request'=>'App/Http/Requests/DocumentoFormRequest','on_start'=>false])
<script>
    $('.clik').eq(0).css('background-color', '#ccc');
    function openSearch(index, city) {
        $('.clik').css('background-color', '');
        $('.clik').eq(index).css('background-color', '#ccc');

        $('.tabcontent').hide();
        $('#' + city).show();
    }
    ;
    $('form').submit(function (e) {

        $('#submit').click();
    })
</script>
@endsection