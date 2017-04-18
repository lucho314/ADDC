@extends('layout/admin')
@section('contenido')
<div class="box">
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Busquedas</h3>
    </div> 
    <div class="box-body">



        <div class="row">
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab"><b>Plano</b></a></li>
                            <li><a href="#tab2default" data-toggle="tab">Partida</a></li>
                            <li><a href="#tab3default" data-toggle="tab"><b>Matrícula</b></a></li>
                            <li><a href="#tab4default" data-toggle="tab"><b>Certificado</b></a></li>
                            <li><a href="#tab5default" data-toggle="tab"><b>Ubicación</b></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <div class="form-inline"> 
                                    <form id="bucarPlano" action="#">
                                        <label>Departamento:</label>
                                        <input class="form-control" type="text" name="nroDpto" > </input>

                                        <label style="margin-left:1%;">Plano:</label>
                                        <input class="form-control" type="text" name="nroPlano" required> </input>
                                        <button class="btn btn-success" type="submit" style="margin-left:1%;">Buscar</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2default">
                                <form id="bucarPartida" action="#">
                                    <div class="form-inline">
                                        <label>Departamento:</label>
                                        <input class="form-control" type="text" name="nroDpto"> </input>
                                        <label style="margin-left:1%;">Partida:</label>
                                        <input class="form-control" type="text" name="nroPartida" required> </input>
                                        <button style="margin-left:1%;" class="btn btn-success" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab3default">
                                <form id="bucarMatricula" action="#">
                                    <div class="form-inline">
                                        <label>Departamento:</label>
                                        <input class="form-control" type="text" name="nroDpto" required> </input>
                                        <label style="margin-left:1%;">Matrícula:</label>
                                        <input class="form-control" type="text" name="nroMatricula" required> </input>
                                        <button style="margin-left:1%;" class="btn btn-success" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab4default">
                                <form id="bucarCertificado" action="#">
                                    <div class="form-inline">
                                        <label>Nro. de certificado:</label>
                                        <input class="form-control" type="text" name="nroCertificado" required> </input>
                                        <button style="margin-left:1%;" class="btn btn-success" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab5default">
                                <form action="#" method="get" id="buscarUbicacion">
                                            <div class="col-md-4  col-lg-4  col-sm-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Departamento:</label>
                                                    <select name="departamento" id="departamento" class="form-control col-md-6" required>
                                                        <option value="">Seleccione Departamento</option>
                                                        @foreach($dptos as $dpto) 
                                                        <option value="{{$dpto->div_de}}">{{$dpto->departamento}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Distrito:</label>
                                                    <select name="distrito" id="distrito" class="form-control col-md-6" required>
                                                        <option>Seleccione Distrito.. &nbsp; &nbsp;</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Localidad:</label>
                                                    <select name="localidad" id="localidad" class="form-control col-md-6" required>
                                                        <option>Seleccione Localidad..</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Seccion:</label>
                                                    <input class="form-control col-md-6" type="text" name="seccion" > </input>
                                                </div> 
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Grupo:</label>
                                                    <input class="form-control col-md-6" type="text" name="grupo" /> </input>
                                                </div> 
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Manzana:</label>
                                                    <input class="form-control col-md-6" type="text" name="manzana"/> </input>
                                                </div> 
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Chacra:</label>
                                                    <input class="form-control col-md-6" type="text" name="chacra"/> </input>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="form-group campos form-inline">
                                                    <label class="col-md-4">Quinta:</label>
                                                    <input class="form-control col-md-6" type="text" name="quinta"> </input>
                                                </div>
                                            </div> 
                                    
                                        <div class="form-group campos text-center">
                                            <button class="btn btn-success" type="submit" style="margin-top: 10px;">Buscar</button>
                                        </div>
                                        </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('documento.resultadoBusqueda')
    </div>

    @endsection
    @section('script')
    <script>
        //    function openSearch(city) {
        //        $('.tabcontent').hide();
        //        $('#' + city).show();
        //    }

        function openSearch(index, city) {
            $('.clik').css('background-color', '');
            $('.clik').eq(index).css('background-color', '#ccc');

            $('.tabcontent').hide();
            $('#' + city).show();
        }
    </script>
    @endsection