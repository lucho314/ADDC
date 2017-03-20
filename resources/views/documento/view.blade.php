@extends('layout/admin')
@section('contenido')
<div>
    <div class="col-md-12 container-fluid">
        <object style="width:100%;height:500px;" type="application/pdf"  data="{{URL::action('DocumentoController@show',$documento->id)}}"></object>
    </div>
    <ul class="tab">

        <div class="col-md-7">
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(0, 'generales')">Datos Generales</a></li>
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'partidas')">Partidas y superficies</a></li>
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(2, 'ubicacion')">Ubicacion Geografica</a></li>
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(3, 'ubicacion_fisica')">Ubicacion Fisica</a></li>
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(4, 'incidencias')">Incidencias</a></li>
        </div>
    </ul>
    <div id="generales" class="tabcontent  datos_tabcontent" style="display: block">
        @include('documento.view.datosGenerales')
    </div>
    <div id="partidas" class="tabcontent datos_tabcontent">
        @include('documento.view.datosPartidas')

    </div>
    <div id="ubicacion" class="tabcontent datos_tabcontent">
        @include('documento.view.datosUbicacion')
    </div>
    <div id="ubicacion_fisica" class="tabcontent datos_tabcontent">
        @include('documento.view.datosUbicacionFisica')
    </div>
    <div id="incidencias" class="tabcontent datos_tabcontent">
        @include('documento.view.incidencias')
    </div>
</div>

@endsection
@section('script')
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