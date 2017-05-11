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

<script>
    function verAntecedente(nroPlano, nroDpto) {
        $.get('/documento/buscarPlano', {'nroPlano': nroPlano, 'nroDpto': nroDpto}, function (data) {
            if (data.recordsTotal > 0) {
                armarDatatableAntecedente(nroPlano, nroDpto);
            } else {
                alert('no se encontro');
            }
        })



        function armarDatatableAntecedente(nroPlano, nroDpto) {
            $('#tabla_antecedentes').DataTable({
                "dom": 'rtip',
                "bDestroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": "/documento/buscarPlano?nroPlano="+nroPlano+"&nroDpto="+nroDpto,
                "columns": [
                    {data: 'documento.tipo.descripcion', name: 'documento.tipo.descripcion', orderable: false, searchable: false},
                    {data: 'nro_partida', name: 'nro_partida'},
                    {data: 'documento.fecha_registro', name: 'documento.fecha_registro'},
                    {data: 'accion', name: 'accion', orderable: false, searchable: false}
                ],
                "language": {
                    "url": "/js/Spanish.json"
                }
            });
            
            $('#tabla_antecedentes_modal').modal('toggle');
            
        }




    }
</script>

@endsection