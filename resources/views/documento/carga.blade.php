@extends('layout/admin')
@section('contenido')
<div class="box">
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Cargar imagen</h3>
    </div> 
    <div class="box-body">
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

            {!!Form::open(['url'=>'documento', 'method'=>'POST', 'autocomplete'=>'off','files'=>'true', 'rules'=>'create', 'id'=>'form_carga']) !!}
            {{Form::token()}}
            <div class="form-group col-md-6 ocultar">
                <!--                <label>Imagen:</label>-->
                <input class="form-control" type="file" name="gral[imagen]" id="imagen"> </input>
            </div>
            <div class="col-md-12 container-fluid" id="grupoImagen">
                <output id="list"></output>
            </div>
            <div class="col-md-12"  id="formularioDocumento" style="display: none">

                <ul class="tab">
                    <li class="clik generales"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(0, 'generales')">Datos Generales</a></li>
                    <li class="clik partidas"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'partidas')">Partidas y Superficies</a></li>
                    <li class="clik ubicacion"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(2, 'ubicacion')">Ubicación Geográfica</a></li>
                    <a href="javascript:ocultar()" id="minimizar"  style="float: left;position: relative; left:25%; color: black"><i class="glyphicon glyphicon-chevron-down" aria-hidden="true"></i></a>
                    <a href="javascript:desocultar()" id="maximizar"  style="display: none; position: relative; float: left; left:25%; color: black"><i class="glyphicon glyphicon-chevron-up" aria-hidden="true"></i></a>
                    <button style="float: right;margin-right: 6px; margin-top: 9px;" class="btn btn-success" id="submit">Aceptar</button>
                    <button style="float: right;margin-right: 10px; margin-top: 9px;" type="reset" id="cancelar" class="btn btn-danger">Cancelar</button>


                </ul>
                <div id="generales" class="tabcontent  datos_tabcontent" style="display: block">
                    @include('documento.create.datosGenerales')
                </div>
                <div id="partidas" class="tabcontent datos_tabcontent">
                    @include('documento.create.datosPartidas')
                </div>
                <div id="ubicacion" class="tabcontent datos_tabcontent">
                    @include('documento.create.datosUbicacion')
                </div>
                <input type="hidden"  value="0" id="biss" name="gral[bis]">
                <input type="hidden" value="2" name="gral[estado_id]">
                <input type="submit" id="enviar" style="display: none">


                <div id="cargando" class="col-md-12 text-center">
                    <img src="{{asset('img/cargando.gif')}}" >
                    <div class="text-center">CARGANDO...</div>
                </div>

            </div>

            <div id="cargaAntecedente" style="display: none">
                <ul class="tab">
                    <li><a href="#" class="tablinks">Datos Generales</a></li>
                    <button style="float: right;margin-right: 6px; margin-top: 9px;" class="btn btn-success" type="submit">Aceptar</button>
                    <button style="float: right;margin-right: 10px; margin-top: 9px;" type="reset" id="cancelar" class="btn btn-danger">Cancelar</button>
                </ul>
                <div class="tabcontent  datos_tabcontent" style="display: block">
                    @include('documento.create.cargaAntecedente')
                </div>

            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
<div class="box ocultar">
    <div class="box-header">
        <h3>Cargar documento en falta</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            {!!Form::open(['url'=>'documento', 'method'=>'POST', 'autocomplete'=>'off','files'=>'true', 'rules'=>'create', 'id'=>'form_carga']) !!}
            {{Form::token()}}
            <div class="col-md-8">
                <div class="form-group col-md-3">
                    <label>Departamento:</label>
                    <select name="gral[nro_dpto]" class="form-control">
                        @foreach($dptos as $dpto)
                        <option value="{{$dpto->codigo_de}}">{{$dpto->departamento}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Tipo documento:</label>
                    <select name="gral[tipo_doc_id]" class="form-control">
                        <option value="1">Plano de mensura</option>
                        <option value="2">Ficha de transferencia</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Plano desde:</label>
                    <input type="number" class="form-control" name="gral[nro_plano]">
                </div>
                <div class="form-group col-md-3">
                    <label>Plano hasta:</label>
                    <input type="number" class="form-control" name="gral[nro_plano_hasta]">
                </div>
            </div>

            <div class="col-md-8">
            <div class="form-group">
                    <label>Observaciones:</label>
                    <textarea class="form-control" name="gral[observaciones]"></textarea>
                </div>
            </div>

            <div class="col-md-8 text-right">
                <input type="submit" class="btn btn-success" value="Aceptar">
            </div>
            <input type="hidden" name="gral[estado_id]" value="6">
            <input type="hidden" name="gral[imagen]" value="">
            {{Form::close()}}
        </div>

    </div>
</div>
@endsection
@section('script')
@include('vendor.lrgt.ajax_script', ['form' => '#form_carga',
'request'=>'App/Http/Requests/DocumentoFormRequest','on_start'=>false])
@include('documento.parcial.cambiar_seccion');
@endsection