var path = '/documento/';
var dpto = 0;
var planoDesde = 0;
var planoHasta = 0;
var partida = 0;
var partidasFallidas = null;
var listaTotalPlanos = null;
var datosModificados = [];
var unidadMedida = null;
$(function () {
    a = $("#responsable").parents()
            .map(function () {
                return $(this).attr('class');
            })
            .get()
            .join(", ");
    console.log(a);
    $("#example1").DataTable({
        "dom": 'lfrtip',
        "language": {
            "url": "/js/Spanish.json"
        }
    });

    $('#tabla-documentos').DataTable({
        "dom": 'frtip',
        "language": {
            "url": "/js/Spanish.json"
        }


    });

    if ($("#form_validar").length > 0) {
        initialize();
        $('input').each(function (i, v) {
            if ($(this).val().indexOf('*') != -1) {
                $(this).removeClass('ingresado').removeClass('sistema').addClass('modificado');
                $(this).val($(this).val().replace('*', ''));
            }
        })
    }

})

$('#submit').click(function () {

    $('#observacion').attr('required', false);
    $('#user2').attr('required', false);
    if (($('#estado').val() === '3' || $('#estado').val() === '4') && $('#observacion').val() === '') {
        $('#derivar_doc_modal').modal('toggle');
        $('#observacion').attr('required', true);
        $('#user2').attr('required', true);
        return false;
    } else if ($('#estado').val() === '2' && $('#observacion').val() === '')
    {
        $('#derivar_doc_modal').modal('toggle');
        $('#observacion').attr('required', true);
        $('#grupo_usuario').hide();
        return false;
    }
    flag = 0;
    flag2 = 0;
    $('input').each(function (i, e) {
        id = $(this).parents('.panel-body').prop('id');
        if (!$('input')[i].validity.valid || $(this).hasClass('repetido')) {
            clase = $(this).css('border', '0.75px solid red')
                    .addClass('mi_placeholder')
                    .attr('placeholder', 'CAMPO REQUERIDO')
                    .parents('.tabcontent').attr('id');
            $('.' + clase).css('background', '#e66e6e');

            flag++;
            flag2++;
        } else {
            $(this).css('border', '');
        }
        if (typeof id !== 'undefined' && id !== $('input').eq(i + 1).parents('.panel-body').prop('id')) {
            console.log(flag);
            if (flag === 0) {
                $(this).parents('.panel')
                        .children('.panel-heading')
                        .css('background', '')
                        .css('border', '')
                        .children('a').css('color', '');
            }
            flag = 0;
        }
        ;
    })

    if (flag2 === 0) {
        $.each(datosModificados, function (i, v) {
            modificado = $('#' + v).val();
            if (modificado.indexOf('*') === -1) {
                $('#' + v).val(modificado + '*');
            }
        });
        $('#enviar').click();
    }


});


var nomeclatura = {
    '3': comprobarNomeclaturaPlano,
    '4': comprobarNomeclaturaFicha
};




$('#imagen').change(function (event) {
    $('.ocultar').hide();
    var nombre = $(this).val();           
    var arrayNombre = nombre.split('-');//10-456pl-4564p
    var longitud = arrayNombre.length; //3 si es plano y 4 si es ficha de lo contrario nomeclatura error.
    $('#biss').val(0);
    if (longitud > 4 || longitud < 3) {
        alert('error de nomenclatura');
        $('.ocultar').show();
        $('#imagen').val("");
        return false;
    }
    if (longitud === 4 && arrayNombre[3] === 'BIS.pdf') {
        delete arrayNombre[3];
        arrayNombre[2] += '.pdf';
        longitud = 3;
        $('#biss').val(1);
    }
    if (!nomeclatura[longitud](arrayNombre))
    {
        alert('error de nomenclatura');
        $('.ocultar').show();
        $('#imagen').val("");
        return false;

    }
    $('#cargando').show();
    $('#formularioDocumento').show().css('opacity', '0.3');
    archivo(event);
})





function archivo(evt) {
    var files = evt.target.files; // FileList object
    // Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {
                // Insertamos la imagen
                document.getElementById("list").innerHTML = ['<object style="width:100%;height:500px;" type="application/pdf"  data="', e.target.result, '" title="', escape(theFile.name), '"></object>'].join('');
            };
        })(f);
        reader.readAsDataURL(f);
    }
}


function comprobarNomeclaturaPlano(nomenclatura) {
    dpto = nomenclatura[0].substring(nomenclatura[0].length - 2); //extraemos el numero de dpto. validar que sea un numero de 2 digitos
    var plano = nomenclatura[1];
    console.log(plano);
    var validaP = (nomenclatura[2] === 'P.pdf');
    var validaDpto = comprobarDpto(dpto);
    var validaPlano = comprobarPlano(plano); //validar si es numerico o si tiene una 'a'
    if (validaP && validaDpto && validaPlano)
    {
        setPlano(nomenclatura);
        return true;
    }
    return false;
}

// 10-564564PL-46546P-20161020.pdf
function comprobarNomeclaturaFicha(nomenclatura) {
    dpto = nomenclatura[0].substring(nomenclatura[0].length - 2);
    var plano = nomenclatura[1];
    var part = nomenclatura[2];
    var fecha = nomenclatura[3];
    var validaFecha = ValidaFecha(fecha);
    var validaDpto = comprobarDpto(dpto);
    var validaPlano = comprobarPlano(plano, true);
    var validapartida = comprobarPartida(part);
    if (validaFecha && validaDpto && validaPlano && validapartida)
    {
        //nomenclatura=[dpto,plano,partida,fecha];
        setFicha(nomenclatura);
        return true;
    }
    return false;
}




function comprobarDpto(dpto) {
    if (dpto.length === 2) {
        if (isNaN(dpto)) {
            return false;
        } else if (!(dpto > 0 && dpto < 18)) {
            return false;
        } else
            return true;
    }
}


function comprobarPartida(part) {
    var tamPartida = part.length;
    partida = part.substring(0, tamPartida - 1);
    if (!isNaN(partida) && partida !== "") {
        var p = part.substring(tamPartida - 1);
        if (p === 'P')
            return true;
    }
    return false;
}

function comprobarPlano(plano, ficha = false) {
    if (ficha) {//valida plano para ficha
        var tamPlano = plano.length;
        planoDesde = planoHasta = plano.substring(0, tamPlano - 2);
        if (!isNaN(planoDesde) && planoDesde !== "") {
            var pl = plano.substring(tamPlano - 2);
            if (pl === 'PL')
                return true;
        }
        return false;
    }
    if (!isNaN(plano) && plano !== "") { //valida plano para plano
        planoDesde = planoHasta = plano;
        return true;
    } else {
        var planoArray = plano.split("a"); // 454a45  454a45as54a54aads4
        var longitud = planoArray.length;
        if (longitud === 2)
        {
            if (!isNaN(planoArray[0]) && !isNaN(planoArray[1])) {  // 4564654     700 
                var tamPlanoDesde = planoArray[0].length;
                var tamPlanoHasta = planoArray[1].length;
                var PartPlanoDesde = planoArray[0].substring(tamPlanoDesde - tamPlanoHasta); // sacamos del plano la cantidad de caractered del hasta
                if (parseInt(PartPlanoDesde) < parseInt(planoArray[1])) {
                    planoDesde = planoArray[0];
                    planoHasta = planoArray[0].substring(0, tamPlanoDesde - tamPlanoHasta) + planoArray[1];
                    return true;
                }
            }
            return false;
        }
}
}


//formato de fecha valido aaaammdd 20170109.pdf
function ValidaFecha(arrayFecha)
{
    if (arrayFecha.length !== 12)
    {
        return false;
    } else {
        var anio = arrayFecha.substring(4, 0);
        var mes = arrayFecha.substring(6, 4);
        var dia = arrayFecha.substring(8, 6);
        var date = new Date(anio, mes, '0');
        if ((dia - 0) > (date.getDate() - 0) || mes < 1 || mes > 12) {
               return false;
              }
        return true;
    }
}



function setPlano(array) {
    var dpto = extraeDpto(array[0]);
    var nroPlanoDesde = planoDesde;
    var nroPlanoHasta = planoHasta;
    console.log(planoDesde, planoHasta);
    getDatos();
    $('#gral_nro_plano').val(nroPlanoDesde);
    $('#gral_nro_plano_hasta').val(nroPlanoHasta);
    $('#gral_nro_dpto').val(dpto);
    $('#gral_tipo_doc').val('Plano de mensura');
    $('.partida').hide();

    //checkDatosInex();

}

function setFicha(array) {
    dpto = extraeDpto(array[0]);
    var nroPlano = array[1];
    var nroPartida = array[2];
    var fechaRegistro = formatearFecha(array[3]);
    nroPlano = nroPlano.substring(nroPlano.length - 2, 0); //le restamos al tamaño total 2 para obtener el num de plano eje: 14574pl->14574
    partida = nroPartida.substring(nroPartida.length - 1, 0);
    $('.partida').show();
    $('#gral_nro_plano').val(planoDesde);
    $('#gral_nro_plano_hasta').val(planoHasta);
    $('#gral_nro_dpto').val(dpto);
    $('#gral_tipo_doc').val('Ficha de transferencia');
    $('#gral_fecha_registro').val(fechaRegistro);
    $('#gral_nro_partida').val(partida);
    $('#gral_grupo-objeto').hide();
    getDatos();
    

}

function extraeDpto(nroDpto) {

    return nroDpto.substring(nroDpto.length - 2);
}

function formatearFecha(fecha) {
    var anio = fecha.substring(4, 0);
    var mes = fecha.substring(6, 4);
    var dia = fecha.substring(8, 6);
    return anio + "-" + mes + "-" + dia;
}



//function checkDuplicados() {
//    $.get(
//            path + 'checkDuplicados/' + dpto + "/" + planoDesde + "/" + planoHasta,
//            function (data) {
//                mostrarPartidas(data);
//            }
//    , 'json');
//}
//
//
//
//function mostrarPartidas(data) {
//    $.each(data, function (i, value) {
//        $('#tbody-seleccion-partidas').append('<tr>\n\
//                                                    <td>' + value['plano'] + '</td>\n\
//                                                    <td> <input type="number" class="form-control required planoPartida conflicto" onchange="repetidos(this);" name="partidasDup[' + value['plano'] + ']" placeholder="Ingrese la partida"/></td>\n\
//                                                </tr>');
//    });
////    if ($(".conflicto").length > 0) {
////        $('#seleccion-partidas-modal').modal('toggle');
////    } else {
//    getDatos();
//    //  }
//}


//$('#definirPartidas').click(function () {
//    if (validarPartidasRequeridas()) {
//        $("#seleccion-partidas-modal").modal('toggle');
//        if ($('.planoPartida').length > 0) {
//            partida = $('.planoPartida').val();
//            var data = $('.planoPartida').serialize();
//            data += '&nroDpto=' + dpto;
//            console.log(data);
//            $.get('checkPartida', data, function (fallidos) {
//                console.log(fallidos);
//                if (fallidos === 0) {
//                    planoDesde = null;
//                    getDatos(partida);
//                } else {
//                    partidasFallidas = fallidos;
//                    $('#confirm-partida').modal('toggle');
//                }
//            }, 'json');
//        } else {
//            partida = $('.conflicto').val();
//            $('#confirm-partida').modal('toggle');
//        }
//    }
//
//});


function validarPartidasRequeridas() {
    flag = true;
    $('.conflicto').each(function () {
        if ($(this).val() === '') {
            $(this).css('background', '#f7a4a4').css('border', '0.75px solid red').parent('.padre').children('.error').text('Error: el campo no puede estar vacio').show();
            return flag = false;

        }
    })
    return flag;
}


$('#cancelar_partida').click(function () {
    $('#seleccion-partidas-modal').modal('toggle');
});
//$('#aceptar_partida').click(function () {
//    if (listaTotalPlanos['encontrados'].length > 0) {
//        console.log('lista total tiene algo');
//        planoDesde = listaTotalPlanos['encontrados'][0];
//        getDatos();
//    } else {
//        $('form input:text').val('sin datos');
//        $('#nro_plano').val(planoDesde);
//        $('#nro_plano_hasta').val(planoHasta);
//        $('#nro_dpto').val(dpto);
//        $('#nro_partida').val(partida);
//        $('#cargando').hide();
//        $('#formularioDocumento').css('opacity', '1');
//    }
//    $('#confirm-partida').modal('toggle');
//});






function getDatos(partidas = null) {
    if (partida === 0)
        partidas = null;
    $.get(path + 'getDatos/',
            {'dpto': dpto, 'plano': planoDesde, 'plano_hasta': planoHasta},
            function (data) {
                if (data.existentes.length > 0) {
                    $('#gral_nro_partida').val(data.existentes[0].partida);
                    $('#gral_inscripcion').val(data.existentes[0].inscripcion);
                    $('#gral_nro_matricula').val(data.existentes[0].matricula);
                    $('#gral_titular').val(data.existentes[0].responsable);
                    $('#tipo_planta').val(data.existentes[0].tipo_planta);
                    $('#tipo_planta_input').val(data.existentes[0].tipo_planta);
                     $('#gral_tipo_planta').val(data.existentes[0].tipo_planta);
                    if (data.existentes[0].tipo_planta > '0003') {
                        unidadMedida = 'Has';
                    } else {
                        unidadMedida = 'm²';
                    }
                    $('.unidad').text(unidadMedida);
                    setUbicacion(data);
                    partidas_y_superficies(data);
                    getDeptos(data.existentes[0].div_de);
                    getDistritos(data.existentes[0].div_de, data.existentes[0].div_di);
                    getLocalidades(data.existentes[0].div_di, data.existentes[0].div_lo);
                   initialize();
                } else {
                    $('form input:text').attr('placeholder',"sin datos");
                    $('#gral_nro_plano').val(planoDesde);
                    $('#gral_nro_plano_hasta').val(planoHasta);
                    $('#gral_nro_dpto').val(dpto);
                    $('#gral_nro_partida').val(partida);
                    $('#cargando').hide();
                    $('#formularioDocumento').css('opacity', '1');
                    getDeptos();
                    initialize();
                }

                //setUbicacionFisica(data.ubicacionFisica);


            });
}

//function setUbicacionFisica(ubicacion) {
//    console.log(ubicacion.caja);
//    $('#sector').val(ubicacion.caja.sector);
//    $('#modulo').val(ubicacion.caja.modulo);
//    $('#estante').val(ubicacion.caja.estante);
//    $('#posicion').val(ubicacion.caja.posicion);
//    $('#profundidad').val(ubicacion.caja.profundidad);
//}
//;


function setUbicacion(datos) {
    $('#tabla_ubicacion').html('');
    j = 0;
    $.each(datos.existentes, function (i, value) {
        $('#tabla_ubicacion').append('<tr id="ubicacion_' + i + '">\n\
                                                    \n\<td class="col-xs-3"><input type="text"  value="' + value.plano + '" required class="modificar form-control anexado" readonly/></td>\n\
                                                     <td class="col-xs-1"><input type="text" name="lote[' + i + '][grupo]" value="' + value.grupo + '" id="lote_' + i + '_grupo" class="form-control anexado modificar" placeholder="Grupo" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][manzana]"  id="lote_' + i + '_manzana" value="' + value.manzana + '" placeholder="manzana" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][parcela]"  id="lote_' + i + '_parcela" value="' + value.parcela + '" placeholder="parcela" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado"  type="text" name="lote[' + i + '][subparcela]" id="lote_' + i + '_subparcela" value="' + value.subparcela + '" placeholder="subparcela" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][chacra]" id="lote_' + i + '_chacra" value="" placeholder="chacra" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][quinta]" id="lote_' + i + '_quinta" value="" placeholder="quinta" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][lamina]" id="lote_' + i + '_lamina" value="' + value.lamina + '" placeholder="lamina" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][sublamina]" id="lote_' + i + '_sublamina" value="' + value.sublamina + '" placeholder="sublamina" readonly></td>\n\
\n\                                                \n\<td class="col-xs-1"><a href=javascript:eliminar("' + i + '")><i class="glyphicon glyphicon-remove" style="color: red"></i></td></a> \n\
                                                    </tr>');
    });

    $('#departamento').val(datos.existentes[0].departamento);
    $('#distrito').val(datos.existentes[0].distrito);
    $('#localidad').val(datos.existentes[0].localidad);
    $('#seccion').val(datos.existentes[0].seccion);
    $('#cargando').hide();
    $('#formularioDocumento').css('opacity', '1');
}
;


function agregar_ubicacion() {
    i = 0;
    if ($('#tabla_ubicacion tr').last().length) {
        id = $('#tabla_ubicacion tr').last().attr('id');
        i = parseInt(id.match(/\d+$/)) + 1;
    }
    $('#tabla_ubicacion').append('<tr id="ubicacion_' + i + '">\n\
                                                    <td class="col-xs-3"><input type="text" value="" id="lote_' + i + '_nro_plano"  required class="form-control modificar anexado" placeholder="Plano" readonly></td>\n\
                                                     <td class="col-xs-1"><input type="text" name="lote[' + i + '][grupo]" required value="" id="lote_' + i + '_grupo" class="form-control modificar" placeholder="Grupo" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][manzana]"  id="lote_' + i + '_manzana"  placeholder="manzana" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][parcela]"  id="lote_' + i + '_parcela"  placeholder="parcela" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][subparcela]" id="lote_' + i + '_subparcela"  placeholder="subparcela" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][chacra]" id="lote_' + i + '_chacra" value="" placeholder="chacra" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][quinta]" id="lote_' + i + '_quinta" value="" placeholder="quinta" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][lamina]" id="lote_' + i + '_lamina"  placeholder="lamina" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text" name="lote[' + i + '][sublamina]" id="lote_' + i + '_sublamina"  placeholder="sublamina" readonly></td>\n\
                                                   \n\<td class="col-xs-1"><a href=javascript:eliminar("' + i + '")><i class="glyphicon glyphicon-remove" style="color: red"></i></td></a> \n\
\n\                                                  </tr>'
            );

    $('#tbody-seleccion-partidas').append('<tr id="' + i + '">\n\
\n\                                                 \n\<td class="col-xs-2"> <input type="text" class="form-control modificar anexado" required name="lote[' + i + '][nro_plano]" value="" id="lote_' + i + '_nro_plano"  placeholder="Plano" readonly/></td>\n\
                                                    \n\<td class="padre col-xs-3"> <input type="text" name="lote[' + i + '][nro_partida]" value="" required  validate="false" class="anexado modificar form-control conflicto" id="lote_' + i + '_nro_partida"  onchange="repetidos(this);" placeholder="Ingrese la partida" readonly/>\n\
                                                    \n\<div class="error" style="display:none; color:red"></div></td>\n\
\n\                                                 \n\<td class="col-xs-3"><div class="row col-xs-11"><input type="text" name="lote[' + i + '][sup_terreno]" value="" required class="anexado modificar form-control" readonly id="lote_' + i + '_sup_terreno"  placeholder="Superficie del terreno"/></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                 \n\<td class="col-xs-3"><div class="row col-xs-11"><input type="text" value="" name="lote[' + i + '][sup_edificada]" required class="anexado modificar form-control" readonly id="lote_' + i + '_sup_edificada"  placeholder="Superficie edificada" /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                 \n\ \n\<td class="col-xs-1"><a href=javascript:eliminar("' + i + '")><i class="glyphicon glyphicon-remove" style="color: red"></i></td></a> \n\
                                                    \n\ <input type="hidden" name="imponible_id[' + i + ']" value="">\n\
\n\                                                 \n\ <input type="hidden" name="catastro_id[' + i + ']" value="">\n\
                                                </tr>');


}






function partidas_y_superficies(data) {
    j = 0;
    $.each(data.existentes, function (i, value) {
        j++;
        $('#tbody-seleccion-partidas').append('<tr id="' + i + '">\n\
                                                 \n\<td class="col-xs-2"><input type="text" name="lote[' + i + '][nro_plano]" value="' + value.plano + '" required  id="lote_' + i + '_nro_plano" class="modificar form-control anexado" readonly/></td>\n\
                                                    <td class="col-xs-3"> <input type="text" name="lote[' + i + '][nro_partida]" value="' + value.partida + '" id="lote_' + i + '_nro_partida" required class="modificar form-control anexado" readonly /></td>\n\
                                                            \n\<td class="col-xs-3"><div class="row col-xs-11"><input type="text" name="lote[' + i + '][sup_terreno]" value="' + value.sup_terreno + '" id="lote_' + i + '_sup_terreno" required class="modificar form-control" readonly /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                         \n\ <td class="col-xs-3"><div class="row col-xs-11"><input type="text" name="lote[' + i + '][sup_edificada]" value="' + value.sup_edif_total + '" id="lote_' + i + '_sup_edificada" required class="modificar form-control anexado" readonly /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
                                                            \n\<td class="col-xs-1"><a href="javascript:eliminar(' + i + ')"><i class="glyphicon glyphicon-remove" style="color: red"></i></td></a> \n\
\n\                                                         \n\ <input type="hidden" name="lote[' + i + '][imponible_id]" value="' + value.clave + '">\n\
\n\                                                         \n\ <input type="hidden" name="lote[' + i + '][catastro_id]" value="' + value.catastro_id + '">\n\
                                                    </tr>');
    });
//    $.each(data.inexistentes, function (i, value) {
//        j++;
//        $('#tbody-seleccion-partidas').append('<tr id="agregados_'+j+'">\n\
//                                                    <td>' + value + '</td>\n\
//\n\                                                 \n\<input type="hidden" name="plano[' + j + ']" value="' + value + '"/>\n\
//                                                    <td class="padre"> <input type="text" name="partida[' + j + ']" value="" required  validate="false" class="modificar form-control conflicto" onchange="repetidos(this);" name="partidasInex[' + value + ']" placeholder="Ingrese la partida" readonly/>\n\
//                                                    <div class="error" style="display:none; color:red"></div></td>\n\
//\n\                                                 \n\<td><div class="row col-xs-11"><input type="text" name="sup_terreno[' + j + ']" value="" required class="modificar form-control" readonly/></div><label class="col-xs-1">' + unidadMedida + '</label></td>\n\
//\n\                                                 \n\<td><div class="row col-xs-11"><input type="text" value="" name="sup_edificada[' + j + ']" required class="modificar form-control" readonly/></div><label class="col-xs-1">' + unidadMedida + '</label></td>\n\
//\n\                                                 \n\ \n\<td><a href=javascript:eliminar("agregados_'+j+'")><i class="glyphicon glyphicon-remove" style="color: red"></i></td></a> \n\
//                                                    \n\ <input type="hidden" name="imponible_id[' + j + ']" value="">\n\
//\n\                                                 \n\ <input type="hidden" name="catastro_id[' + j + ']" value="">\n\
//                                                </tr>');
//
//    });
    $('#cargando').hide();
    $('#formularioDocumento').css('opacity', '1');

}


function eliminar(i) {
    $('#ubicacion_' + i).remove();
    $('#' + i).remove();
}




$('#departamento').change(function () {
    getDistritos($(this).val());
});

$('#distrito').change(function () {
    getLocalidades($(this).val());
});

function getDeptos(dato = '') {
    $.get(path + 'getDptos/', function (datos) {
        $.each(datos, function (i, value) {
            $('#departamento').append('<option value="' + value.div_de + '">' + value.codigo_de + '-' + value.departamento + '</option>');
        });
        $('#departamento').val(dato);
        $('#departamento_input').val(dato);
    });

}

function getDistritos(numDpto, dato = '') {
    $.get(path + 'getDtos/' + numDpto, function (datos) {

        $('#distrito').html('<option value="">Seleccione Distrito.. &nbsp; &nbsp;</option>');
        $('#localidad').html('<option valie="">Seleccione localidad..</option>');
        $.each(datos, function (i, value) {
            $('#distrito').append('<option value="' + value.div_di + '">' + value.distrito + '</option>');
        });
        $('#distrito').val(dato);
        $('#gral_distrito').val(dato);
        $('#distrito_input').val(dato);
    });
}

function getLocalidades(dto, dato = '') {
    $.get(path + 'getLocalidades/' + dto, function (datos) {
        
        $('#localidad').html('<option value="">Seleccione localidad..</option>');
        $.each(datos, function (i, value) {
            console.log(value);
            $('#localidad').append('<option value="' + value.div_lo + '">' + value.localidad + '</option>');
           });
        $('#localidad').val(dato);
        $('#gral_localidad').val(dato);
        $('#localidad_input').val(dato);
    });
}


$('#bucarPlano').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarPlano';
    armarDatatablePlano(url, datos);

});
$('#bucarPartida').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarPartida/';
    armarDatatable(url, datos);
});
$('#bucarMatricula').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarMatricula';
    armarDatatable(url, datos);
});

$('#buscarUbicacion').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarUbicacion';
    armarDatatable(url, datos);
});
$('#buscarResponsable').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarResponsable';
    armarDatatable(url, datos);
});



function armarDatatablePlano(url, datos) {
    console.log(datos);
    $('#tabla-documentos').DataTable({
        "dom": 'frtip',
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": path + url + '?' + datos,
        "columns": [
            {data: 'tipo_doc', name: 'tipo_doc', searchable: false},
            {data: 'nro_dpto', name: 'nro_dpto', "searchable": false},
            {data: 'nro_plano', name: 'nro_plano'},
            {data: 'temporal[0].nro_partida', name: 'temporal.nro_partida'},
            {data: 'fecha_registro', name: 'fecha_registro', "searchable": false},
            {data: 'estado.descripcion', name: 'estado.descripcion'},
            {data: 'accion', name: 'accion', orderable: false, searchable: false}
        ],

        "language": {
            "url": "/js/Spanish.json"
        }

    });
}


function armarDatatable(url, datos) {
    console.log(datos);
    $('#tabla-documentos').DataTable({
        "dom": 'frtip',
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": path + url + '?' + datos,
        "columns": [
            {data: 'documento.tipo_doc', name: 'documento.tipo_doc', searchable: false},
            {data: 'nro_dpto', name: 'nro_dpto', "searchable": false},
            {data: 'nro_plano', name: 'nro_plano', searchable: false},
            {data: 'nro_partida', name: 'nro_partida', searchable: false},
            {data: 'documento.fecha_registro', name: 'documento.fecha_registro', "searchable": false},
            {data: 'documento.estado.descripcion', name: 'documento.estado.descripcion'},
            {data: 'accion', name: 'accion', orderable: false, searchable: false}
        ],

        "language": {
            "url": "/js/Spanish.json"
        }

    });
}




function buscarJson(json, valorBuscar) {
    retornar = false;
    $.each(json, function (i, valor) {
        if (i === valorBuscar) {
            retornar = true;
            return false;
        }
    });
    return retornar;
}

function checkDatosInex() {
    $('#tbody-seleccion-partidas').html('');
    $.get(path + 'checkDatosInex/' + dpto + "/" + planoDesde + "/" + planoHasta, function (totales) {
        $.each(totales.plano, function (i, value) {
            if (value === '') {
                $('#tbody-seleccion-partidas').append('<tr>\n\
                                                    <td>' + i + '</td>\n\
                                                    <td class="padre"> <input type="number" value="' + value + '" required  validate="false" class="form-control conflicto" onchange="repetidos(this);" name="partidasInex[' + i + ']" placeholder="Ingrese la partida"/>\n\
                                                    <div class="error" style="display:none; color:red"></div></td>\n\
                                                </tr>');
            } else {
                $('#tbody-seleccion-partidas').append('<tr>\n\
                                                    <td>' + i + '</td>\n\
                                                    <td> <input type="number" value="' + value + '" required class="form-control" readonly />\n\
                                                </tr>');
            }

        });
        $.each(totales.planoDup, function (i, value) {
            html = '<tr><td>' + i + '</td>\n\
                   <td><select name="duplicados[' + i + ']" class="form-control" required><option value="">Selecione Partida</option>';
            $.each(totales.planoDup[i], function (j, val) {
                html += '<option>' + val + '</option>';
            });
            $('#tbody-seleccion-partidas').append(html + "</select></td></tr>");
        });

    }, 'json');

    getDatos();
}


function repetidos(partida) {
    if (partida.value == '9999') {
        $(partida).removeClass('repetido').css('background', '#fff').css('border-color', '#d2d6de').parent('.padre').children('.error').hide();
        return false;
    }
    flag = -1;
    input = null;
    $('.conflicto').each(function () {
        console.log($(this).val(), partida, flag)
        if ($(this).val() === partida.value) {
            flag++;
            $input = $(partida);
        }
    })
    if (flag) {
        $input.addClass('repetido').css('background', '#f7a4a4').css('border', '0.75px solid red').parent('.padre').children('.error').text('Error: Partida repetida').show();
        $('#definirPartidas').prop('disabled', true);
    } else {
        repetidaPartidaDb(partida)
    }
}


function repetidaPartidaDb(partida) {
    $(partida).removeClass('repetido').css('background', '#fff').css('border-color', '#d2d6de').parent('.padre').children('.error').hide();
    $('#definirPartidas').prop('disabled', false);
    $.get(path + 'compruebaPartidaRepetida/' + dpto + "/" + partida.value, function (dato) {
        if (dato > 0) {
            $(partida).addClass('repetido').css('background', '#f7a4a4').css('border', '0.75px solid red').parent('.padre').children('.error').text('Error: La partida ya existe en la BD').show();
            $('#definirPartidas').prop('disabled', true);
        }
    }, 'json')

}

$('#cancelar').click(function () {
    $('#formularioDocumento').hide();
    $('.ocultar').show();
})

$('input').dblclick(function () {
    $(this).attr('readonly', false).css('background', 'none').css('border', 'solid 1px #d2d6de')
})

$('select').dblclick(function () {
    $(this).attr('readonly', false).css('background', 'none').css('border', 'solid 1px #d2d6de')
})



$(document).on("dblclick", '.modificar', function () {
    $(this).attr('readonly', false).css('background', 'none').css('border', 'solid 1px #d2d6de');
    if (datosModificados.indexOf($(this).attr('id')) === -1) {
        datosModificados.push($(this).attr('id'));
    }
    console.log(datosModificados);
})

$('.select-modificar').change(function () {
    $('#' + $(this).attr('id') + '_input').val($(this).val())
    if (datosModificados.indexOf($(this).attr('id') + '_input') === -1) {
        datosModificados.push($(this).attr('id') + '_input');
        console.log(datosModificados);
    }
    ;
});

function eliminar_registro(id) {
    swal({
        title: "Está seguro?",
        text: "Esta acción eliminará todos los registro de este lote de forma permanente",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Eliminar',
        cancelButtonText: "Cancelar",
        closeOnCancel: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
            function () {
                $.get(path + 'eliminar_registro', {'id': id}, function (data) {
                    if (data.Error) {
                        eliminar(id);
                        swal("Eliminado!", "Registro eliminado correctamente!", "success");
                    } else {

                        swal("No eliminado!", data.mensaje, "error");
                    }
                }, 'JSON');
            });
}


$('#gral_responsable').change(function () {
    var responsable = $(this).val();
    if (!isNaN(responsable))
    {
        $.get(path + 'get_persona', {'dni': responsable}, function (dato) {
            $('#gral_responsable').val(dato.nombre_completo);
        }, 'json').fail(function () {});
    }
});


function agregar_antecedente() {
    $('#grupo_antecedente').append('<input type="number" placeholder="Nro plano antecedente" name="plano_ant[]" class="form-control" style="margin-bottom: 6%">');
}

function eliminar_carga(id) {
    swal({
        title: "Está seguro?",
        text: "Esta acción eliminará el documento seleccionado",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Eliminar',
        cancelButtonText: "Cancelar",
        closeOnCancel: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
            function () {
                $.get(path + 'eliminar', {'id': id}, function (data) {
                    if (data.Error) {
                        swal("Eliminado!", "Registro eliminado correctamente!", "success");
                    } else {

                        swal("No eliminado!", data.mensaje, "error");
                    }
                }, 'JSON');
            });
}


$(document).on('change', '.anexado', function () {
    validate();
})

$('#gral_tipo_planta').change(function(){
    if($(this).val()>3){
        $('.unidad').text('Has');
    }
    else{
        $('.unidad').text('m²');
    }
})