@extends('layout/admin')
@section('contenido')

<div class="box">
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Busquedas</h3>
    </div> 
    <div class="box-body">
        <ul class="tab">
            <li class="clik plano"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(0, 'plano')">Plano</a></li>
            <li class="clik partida"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(1, 'partida')">Partida</a></li>
            <li class="clik matricula"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(2, 'matricula')">Matricula</a></li>
            <li class="clik certificado"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(3, 'certificado')">Certificado</a></li>
            <li class="clik ubicacion"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(4, 'ubicacion')">Ubicacion</a></li> <!-- onclick="openSearch('ubicacion')"-->
            <li class="clik fecha"><a href="javascript:void(0)" class="tablinks" onclick="openSearch(5, 'fecha')">Fecha de registro</a></li>
        </ul>

        <form id="bucarPlano" action="#">
            <div id="plano" class="tabcontent">
                <div class="col-md-8 form-inline text-center busqueda" >
                    <div class="form-group campos">
                        <label>Departamento:</label>
                        <input class="form-control" type="text" name="nroDpto" > </input>
                    </div>
                    <div class="form-group campos">
                        <label>Plano:</label>
                        <input class="form-control" type="text" name="nroPlano" required> </input>
                    </div>
                    <div class="form-group campos">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <form id="bucarPartida" action="#">
            <div id="partida" class="tabcontent">
                <div class="col-md-8 form-inline text-center busqueda" >
                    <div class="form-group campos">
                        <label>Departamento:</label>
                        <input class="form-control" type="text" name="nroDpto"> </input>
                    </div>
                    <div class="form-group campos">
                        <label>Partida:</label>
                        <input class="form-control" type="text" name="nroPartida" required> </input>
                    </div>
                    <div class="form-group campos">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <form id="bucarMatricula" action="#">
            <div id="matricula" class="tabcontent">
                <div class="col-md-8 form-inline text-center busqueda" >
                    <div class="form-group campos">
                        <label>Departamento:</label>
                        <input class="form-control" type="text" name="nroDpto" required> </input>
                    </div>
                    <div class="form-group campos">
                        <label>Matrícula:</label>
                        <input class="form-control" type="text" name="nroMatricula" required> </input>
                    </div>
                    <div class="form-group campos">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <form id="bucarCertificado" action="#">
            <div id="certificado" class="tabcontent">
                <div class="col-md-8 form-inline text-center busqueda" >
                    <div class="form-group campos">
                        <label>Nro. de certificado:</label>
                        <input class="form-control" type="text" name="nroCertificado" required> </input>
                    </div>
                    <div class="form-group campos">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="#" method="get" id="buscarUbicacion">
            <div id="ubicacion" class="tabcontent">
                <div class="col-md-12 text-center" >
                    <div class="col-md-4 row">
                        <div class="form-group campos form-inline">
                            <label class="col-md-4">Departamento:</label>
                            <select name="departamento" id="departamento" class="form-control col-md-6" required>
                                <option value="">Seleccione Departamento..&nbsp; &nbsp;</option>
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
                </div>

                <div class="form-group campos text-center">
                    <button class="btn btn-success" type="submit" style="margin-top: 10px;">Buscar</button>
                </div>

            </div>
        </form>
        <form id="buscarFecha" action="#">
            <div id="fecha" class="tabcontent">
               <div class="col-md-8 form-inline text-center busqueda" >
                    <div class="form-group campos">
                        <label>Departamento:</label>
                        <input class="form-control" type="text" name="nro_dpto" > </input>
                    </div>
                    <div class="form-group campos">
                        <label>Fecha de registro:</label>
                        <input class="form-control" type="date" name="fecha_registro" required> </input>
                    </div>
                    <div class="form-group campos">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
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