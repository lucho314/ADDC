@extends('layout/admin')
@section('contenido')
   
<div class="box">
    <div class="box-header">
        <h3 style="margin: 0px 0px 0px 2px;">Busquedas</h3>
    </div> 
     <div class="box-body">
        <ul class="tab">
            <li><a href="javascript:void(0)" class="tablinks" onclick="openSearch('plano')">Plano</a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openSearch('partida')">Partida</a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openSearch('matricula')">Matricula</a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openSearch('ubicacion')">Ubicacion</a></li> <!-- onclick="openSearch('ubicacion')"-->
            <li><a href="javascript:void(0)" class="tablinks">Responsables</a></li>
        </ul>

        <form id="bucarPlano" action="#">
            <div id="plano" class="tabcontent">
                <div class="col-md-8 form-inline text-center busqueda" >
                    <div class="form-group campos">
                        <label>Departamento:</label>
                        <input class="form-control" type="text" name="nroDpto" required> </input>
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
                        <input class="form-control" type="text" name="nroDpto" required> </input>
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
        <form action="#" method="get" id="buscarUbicacion">
            <div id="ubicacion" class="tabcontent">
                <div class="col-md-12 text-center" >
                    <div class="col-md-4 row">
                        <div class="form-group campos form-inline">
                            <label class="col-md-4">Departamento:</label>
                            <select name="departamento" id="departamento" class="form-control col-md-6">
                                @foreach($dptos as $dpto) 
                                <option value="{{$dpto->div_de}}">{{$dpto->departamento}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
               
                    <div class="col-md-4 row">
                        <div class="form-group campos form-inline">
                            <label class="col-md-4">Distrito:</label>
                            <select name="distrito" id="distrito" class="form-control col-md-6">
                                <option>Seleccione Distrito.. &nbsp; &nbsp;</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 row">
                        <div class="form-group campos form-inline">
                            <label class="col-md-4">Localidad:</label>
                            <select name="localidad" id="localidad" class="form-control col-md-6">
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
        <form id="buscarResponsable" action="#">
            <div id="responsable" class="tabcontent">
                <div class="col-md-12 text-center" >
                    <div class="col-md-4 row">
                        <div class="form-group campos form-inline">
                            <label class="col-md-4">Nombres:</label>
                            <input class="form-control col-md-6" type="text" name="apellido_y_nombre_padre"> </input>
                        </div>
                    </div>
                    <div class="col-md-4 row">
                        <div class="form-group campos  form-inline">
                            <label class="col-md-4">Apellido:</label>
                            <input class="form-control col-md-6" type="text" name="razon_social" > </input>
                        </div>
                    </div>


                    <div class="col-md-4 row">
                        <div class="form-group campos  form-inline">
                            <label class="col-md-4">Numero de Documento:</label>
                            <input class="form-control col-md-6" type="text" name="numero_documento" > </input>
                        </div>
                    </div>
                    <div class="col-md-4 row">
                        <div class="form-group campos  form-inline">
                            <label class="col-md-4">Numero de Cuit:</label>
                            <input class="form-control col-md-6" type="text" name="cuit" > </input>
                        </div>
                    </div>
                </div>
                <div class="form-group campos text-center">
                    <button class="btn btn-success" type="submit">Buscar</button>
                </div>
            </div>
     </div>
            @include('documento.resultadoBusqueda')
</div>

@endsection
@section('script')
<script>
    function openSearch(city) {
        $('.tabcontent').hide();
        $('#' + city).show();
    }
</script>
@endsection