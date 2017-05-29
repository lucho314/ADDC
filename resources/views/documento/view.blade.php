@extends('layout/admin')
@section('contenido')
<div>
    <div class="col-md-12 container-fluid">
        <object style="width:100%;" id="objeto_imagen" type="application/pdf"  data="{{URL::action('DocumentoController@show',$documento->id)}}"></object>
    </div>
    <ul class="tab">


        <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(0, 'generales')">Datos Generales</a></li>
         @if($documento->hasVigente())
            @if($relacion == 'datosSat')
                <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'responsables')">Responsables</a></li>
            @endif
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(2, 'partidas')">Partidas y superficies</a></li>
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(3, 'ubicacion')">Ubicacion Geografica</a></li>
        @endif
        <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(4, 'ubicacion_fisica')">Ubicacion Fisica</a></li>
        <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(5, 'incidencias')">Incidencias</a></li>
        @if(count($precedentes)>0)
            <li class="clik"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'precedentes')">Documentos vigente</a></li>
        @endif
        <a href="javascript:ocultar()" id="minimizar" style="float: right;margin-top: 1.5%;right: 2%;position: relative;color: black;"><i class="glyphicon glyphicon-chevron-down" aria-hidden="true"></i></a>
        <a href="javascript:desocultar()" id="maximizar"  style="display: none; float: right;margin-top: 1.5%;right: 2%;position: relative;color: black;"><i class="glyphicon glyphicon-chevron-up" aria-hidden="true"></i></a>

    </ul>
    @if($documento->hasVigente())
        <div id="generales" class="tabcontent  datos_tabcontent" style="display: block">
            @include('documento.view.datosGenerales')
        </div>
        @if($relacion == 'datosSat')
            <div id="responsables" class="tabcontent  datos_tabcontent">
                @include('documento.view.datosResponsables')
            </div>
        @endif
        <div id="partidas" class="tabcontent datos_tabcontent">
            @include('documento.view.datosPartidas')
        </div>
        <div id="ubicacion" class="tabcontent datos_tabcontent">
            @include('documento.view.datosUbicacion')
        </div>
    @else 
        <div id="generales" class="tabcontent  datos_tabcontent" style="display: block">
            @include('documento.view.cargaAntecedente')
        </div>
        <div id="precedentes" class="tabcontent  datos_tabcontent">
             @include('documento.view.datosPrecedentes')
        </div>
    @endif
    <div id="ubicacion_fisica" class="tabcontent datos_tabcontent">
        @include('documento.view.datosUbicacionFisica')
    </div>
    <div id="incidencias" class="tabcontent datos_tabcontent">
        @include('documento.view.incidencias')
    </div>
</div>

@include('documento.view.tablaAntecedenteModal')
@endsection
    @section('script')
    <script>
        $('#objeto_imagen').css('height', mitadAlto);
    </script>
    @include('documento.parcial.cambiar_seccion');

@endsection