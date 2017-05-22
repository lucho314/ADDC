/* global parseFloat */

var path = '/documento/';
var dpto = 0;
var planoDesde = 0;
var planoHasta = 0;
var partida = null;
var tipo_doc = null;
var partidasFallidas = null;
var listaTotalPlanos = null;
var datosModificados = [];
var unidadMedida = 'm²';
var list_modif = [];
var auxFormulario;
var objetosMensurasEspecialesId = ['4', '5', '6'];
var alto = screen.height;
var mitadAlto = alto / 2;
var fecha_certificado = null;

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
        getCambios();
    }

})


/*limpia el log de cambios por si queda alguno sin
 * conexion con documento.
 * */
function limpiarLog() {
    $.get('/eliminar_log');
}





$('#submit').click(function () {
    $('#observacion').attr('required', false);
    $('#area_id').attr('required', false);
    if (($('#estado').val() === '3' || $('#estado').val() === '4') && $('#observacion').val() === '') {
        $('#derivar_doc_modal').modal('toggle');
        $('#observacion').attr('required', true);
        $('#area_id').attr('required', true);
        return false;
    } else if ($('#estado').val() === '2' && $('#observacion').val() === '')
    {
        $('#derivar_doc_modal').modal('toggle');
        $('#observacion').attr('required', true);
        $('#area_id').hide();
        return false;
    }

});




$('#imagen').change(function (event) {
    $('.ocultar').hide();
    var nombre = $(this).val();
    nombre = nombre.split('\\');
    nomenclatura = nombre[nombre.length - 1].slice(0, -4);
    if (comprobarNomeclaturaPlano(nomenclatura) || comprobarNomeclaturaFicha(nomenclatura)) {
        $('#cargando').show();
        $('#formularioDocumento').show().css('opacity', '0.3');
        archivo(event);
        $('#biss').val(0);
        limpiarLog();
        inicializarDatos(nomenclatura);
    } else {
        alert('error de nomenclatura');
        $('.ocultar').show();
        $('#imagen').val("");
        return false;
    }

});





function archivo(evt) {
    var files = evt.target.files; // FileList object
    // Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {
                // Insertamos la imagen
                document.getElementById("list").innerHTML = ['<object id="objeto_imagen" style="width:100%;height:' + mitadAlto + 'px;" type="application/pdf"  data="', e.target.result, '" title="', escape(theFile.name), '"></object>'].join('');
            };
        })(f);
        reader.readAsDataURL(f);
    }
}

function comprobarNomeclaturaPlano(nomenclatura) {

    if ((/^(0[1-9]|[1][0-7])[\-](\d+a?\d+)[\-](\P)(\-(BIS))?$/).test(nomenclatura))
    {
        tipo_doc = 1;
        return true;
    }
    return false;
}

// 10-564564PL-46546P-20161020.pdf
function comprobarNomeclaturaFicha(nomenclatura) {
    var pattFicha = /^(0[1-9]|[1][0-7])[\-](\d+)(\PL)[\-](\d+)(\P)((\-)\d{8})?$/;
    if (pattFicha.test(nomenclatura)) {
        tipo_doc = 2;
        fecha = nomenclatura.split("-");
        return (typeof (fecha[3]) !== 'undefined') ? ValidaFecha(fecha[3]) : true;
    }
    return false;
}





function inicializarDatos(nomenclatura) {
    nomemclaturaArray = nomenclatura.split('-');
    dpto = nomemclaturaArray[0];
    planoArray = nomemclaturaArray[1].split('a');
    setPlanos(nomemclaturaArray[1]);
    partida = (nomemclaturaArray[2] !== 'P') ? parseInt(nomemclaturaArray[2]) : '';
    inicializarHtml();
    getDatos(null, tipo_doc);
}

function setPlanos(stringPlano) {
    plano = stringPlano.split('a');
    planoDesde = parseInt(plano[0]);
    planoHasta = parseInt(plano[0]);
    if (typeof plano[1] !== 'undefined')
    {
        cantLetras = plano[1].length;
        planoHasta = plano[0].slice(0, -cantLetras);
        planoHasta += plano[1];
        if (planoHasta < planoDesde) {
            alert('error de nomenclatura');
            $('.ocultar').show();
            $('#imagen').val("");
        }
    }
}
function inicializarHtml() {
    $('#gral_nro_plano').val(planoDesde);
    $('#gral_nro_plano_hasta').val(planoHasta);
    $('#gral_nro_dpto').val(dpto);
    $('#gral_tipo_doc').val(tipo_doc);
    if (tipo_doc === 1) {
        $('#grupo_certificado').hide();
        $('.partida').hide();
    } else {
        $('#gral_nro_partida').val(partida);
        $('#grupo_objeto').hide();
        $('#gral_fecha_certificado').val(fecha_certificado);
    }
}

function ValidaFecha(arrayFecha)
{
    console.log(arrayFecha);
    if (arrayFecha.length !== 8)
    {
        return false;
    } else {
        var anio = arrayFecha.substring(4, 0);
        var mes = arrayFecha.substring(6, 4);
        var dia = arrayFecha.substring(8, 6);
        fecha_certificado = anio + "-" + mes + "-" + dia;
        return !isNaN(Date.parse(fecha_certificado));
    }
}



function getDatos(partidas = null, tipoDoc = null) {
    $.get(path + 'getDatos/',
            {'dpto': dpto, 'plano': planoDesde, 'plano_hasta': planoHasta, 'tipo_doc': tipoDoc, 'partida': partida},
            function (data) {
                if (data.existentes.length > 0) {
                    $('#cargaAntecedente').remove();
                    setUbicacion(data);
                    partidas_y_superficies(data);
                    getDeptos(data.existentes[0].departamento_id);
                    getDistritos(data.existentes[0].departamento_id, data.existentes[0].distrito_id);
                    getLocalidades(data.existentes[0].distrito_id, data.existentes[0].localidad_id);
                    cargarExistentes(data.existentes[0]);
                    if (tipoDoc !== null && tipoDoc === 'plano') {
                        mesa[tipoDoc](data.mesa);
                    }
                   // if (typeof(data.inexistentes)==='object') {
                       // console.log('inexistente',data.inexistentes);
                        cargaInexistente(data.inexistentes);
                   // }
                    //if (data.imponible_historico.length > 0) {
                  //      console.log('historico',data.imponible_historico);
                        cargaHistorico(data.imponible_historico);
                  //  }
                  //  console.log(typeof(data.inexistentes));

                } else
                {
                    auxFormulario = $('#formularioDocumento');
                    cargaAntecedente();

                 
                    $.each(data.inexistentes, function (i, valor) {
                        console.log('inexistente:',valor);
                        $('form').append('<input type="hidden" name="inexistentes[' + i + '][nro_plano]"  value="' + valor + '" required  class="modificar form-control anexado" readonly/>\n\                                                         <input type="hidden" name="inexistentes[' + i + '][nro_partida]" class="partidaInex">\n\
                                          <input type="hidden" name="inexistentes[' + i + '][vigente]" value="0">');

                    });
                    if (data.imponible_historico.length === 0){
                        observarCambioObjeto();
                    }
                else{
                    $.each(data.imponible_historico, function (i, valor) {
                    console.log('historico',valor.col10);
                    clave = valor.clave_imponible.split('-');
                    $('form').append('<input type="hidden" name="historico[' + i + '][nro_plano]"  value="' + valor.col10 + '" required  class="modificar form-control anexado" readonly/>\n\
                                 <input type="hidden" name="historico[' + i + '][nro_partida]" value="' + parseInt(clave[1]) + '">\n\
                                  <input type="hidden" name="historico[' + i + '][imponible_id]" value="' + valor.clave_imponible + '">\n\                                             <input type="hidden" name="historico[' + i + '][vigente]" value="0">\n\
                    ');
                });
                            }
                 
                   
                }
                initialize();
            });
}



function cargaAntecedente(){
    $('#formularioDocumento').remove();
    $('#cargaAntecedente').show();
    $('#gral_nro_plano').val(planoDesde);
    $('#gral_nro_plano_hasta').val(planoHasta);
    $('#gral_nro_dpto').val(dpto);
    $('#gral_tipo_doc_id').val(tipo_doc);
  }


function cargarExistentes(existentes) {
    $('#gral_nro_partida').val(existentes.partida);
    $('#gral_inscripcion').val(existentes.inscripcion);
    $('#gral_nro_matricula').val(existentes.matricula);
    $('#gral_titular').val(existentes.responsable);
    $('#tipo_planta').val(existentes.tipo_planta_id);
    $('#gral_seccion').val(existentes.seccion);
    console.log(existentes.tipo_planta_id);
    if (existentes.tipo_planta_id > '0003') {
        unidadMedida = 'Has';
    } else {
        unidadMedida = 'm²';
    }
    $('.unidad').text(unidadMedida);
}

function cargaInexistente(planos) {
    $.each(planos, function (i, valor) {
        $('#tabla_ubicacion').append('<tr>\n\
                        <td class="col-xs-3"><input type="text"  value="' + valor + '" required class="modificar form-control anexado" readonly/></td>\n\
                        <td class="col-xs-9"><input type="text" colspan="9" value="DATOS INEXISTENTES"  class="form-control anexado" readonly/></td>\n\
                   </tr>');
        $('#tbody-seleccion-partidas').append('<tr>\n\
                                 <input type="hidden" name="inexistentes[' + i + '][vigente]" value="0">\n\
                                <td class="col-xs-2"><input type="text" name="inexistentes[' + i + '][nro_plano]"  value="' + valor + '" required  class="modificar form-control anexado" readonly/></td>\n\
                                <td class="col-xs-2"> <input type="text" name="inexistentes[' + i + '][nro_partida]" value="" id="lote_' + i + '_nro_partida" required class="form-control anexado"/></td>\n\
                                 <td class="col-xs-8"><input type="text" colspan="8" value="DATOS INEXISTENTES"  class="form-control anexado" readonly/></td>\n\
    </tr>');
    });
}


function cargaHistorico(historicos) {
    $.each(historicos, function (i, valor) {
        clave = valor.clave_imponible.split('-');
        $('#tabla_ubicacion').append('<tr>\n\
                                            <td class="col-xs-3"><input type="text"  value="' + valor.col10 + '" required class="modificar form-control anexado" readonly/></td>\n\
                                            <td class="col-xs-9"><input type="text" colspan="9" value="PLANO NO VIGENTE"  class="form-control anexado" readonly/></td>\n\
                                       </tr>');
        $('#tbody-seleccion-partidas').append('<tr>\n\
                                                    <td class="col-xs-2"><input type="text" name="historico[' + i + '][nro_plano]"  value="' + valor.col10 + '" required  class="modificar form-control anexado" readonly/></td>\n\
                                                    <td class="col-xs-2"> <input type="text" name="historico[' + i + '][nro_partida]" value="' + parseInt(clave[1]) + '" id="lote_' + i + '_nro_partida" required class="form-control anexado"/></td>\n\
                                                    <td class="col-xs-8"><input type="text" colspan="8" value="PLANO NO VIGENTE"  class="form-control anexado" readonly/></td>\n\
                                                    <input type="hidden" name="historico[' + i + '][imponible_id]" value="' + valor.clave_imponible + '">\n\
\n\                                                 <input type="hidden" name="historico[' + i + '][vigente]" value="0">\n\
                                                </tr>');
    });
}





function observarCambioObjeto() {
    $('#form_carga').find('#gral_objeto_id').change(function () {
        objetoId = $(this).val();
        if (objetosMensurasEspecialesId.indexOf(objetoId) !== -1) {
            getDeptos();
            $('#form_carga').append(auxFormulario);
            $('#cargaAntecedente').remove();
            $('#gral_nro_partida').val(partida);
            $('#nro_plano').val(planoDesde);
            $('#nro_plano_hasta').val(planoHasta);
            $('#nro_dpto').val(dpto);
            $('#tipo_doc').val(tipo_doc);
            $('#cargando').hide();
            $('#formularioDocumento').css('opacity', '1').css("pointer-events","all");;
            $('.agregar_').show();
            $('#form_carga').append('<input type="hidden" name="gral[objeto_id]" value="' + objetoId + '">');
            $('#grupo_objeto').remove();
        }
    });
}
;
function setUbicacion(datos) {
    $('#tabla_ubicacion').html('');
    j = 0;
    $.each(datos.existentes, function (i, value) {
        $('#tabla_ubicacion').append('<tr id="ubicacion_' + i + '">\n\
                                                    \n\<td class="col-xs-3"><input type="text"  value="' + value.plano + '" required class="modificar form-control anexado" readonly/></td>\n\
                                                     <td class="col-xs-1"><input type="text"  value="' + value.grupo + '" id="lote_' + i + '_grupo" class="form-control anexado modificar" placeholder="Grupo" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"   id="lote_' + i + '_manzana" value="' + value.manzana + '" placeholder="manzana" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"   id="lote_' + i + '_parcela" value="' + value.parcela + '" placeholder="parcela" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado"  type="text"  id="lote_' + i + '_subparcela" value="' + value.subparcela + '" placeholder="subparcela" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="lote_' + i + '_chacra" value="" placeholder="chacra" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="lote_' + i + '_quinta" value="" placeholder="quinta" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="lote_' + i + '_lamina" value="' + value.lamina + '" placeholder="lamina" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="lote_' + i + '_sublamina" value="' + value.sublamina + '" placeholder="sublamina" readonly></td>\n\
                                                    </tr>');
    });
    $('#departamento').val(datos.existentes[0].departamento);
    $('#distrito').val(datos.existentes[0].distrito);
    $('#localidad').val(datos.existentes[0].localidad);
    $('#seccion').val(datos.existentes[0].seccion);
    $('#cargando').hide();
    $('#formularioDocumento').css('opacity', '1').css("pointer-events","all");
}
;
function agregar_ubicacion() {
    i = 0;
    if ($('#tabla_ubicacion tr').last().length) {
        id = $('#tabla_ubicacion tr').last().attr('id');
        i = parseInt(id.match(/\d+$/)) + 1;
    }
    $('#tabla_ubicacion').append('<tr id="ubicacion_' + i + '">\n\
                                                    \n\<td class="col-xs-3"><input type="text"  class="modificar form-control anexado" id="lote_' + i + '" readonly/></td>\n\
                                                     <td class="col-xs-1"><input type="text"   id="especial_' + i + '_grupo" name="especial[' + i + '][grupo]" class="form-control anexado modificar" placeholder="Grupo" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"   id="especial_' + i + '_manzana" name="especial[' + i + '][manzana]"  placeholder="manzana" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"   id="especial_' + i + '_parcela" name="especial[' + i + '][parcela]" placeholder="parcela" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado"  type="text"  id="especial_' + i + '_subparcela" name="especial[' + i + '][subparcela]"  placeholder="subparcela" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="especial_' + i + '_chacra" name="especial[' + i + '][chacra]" value="" placeholder="chacra" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="especial_' + i + '_quinta" name="especial[' + i + '][quinta]" value="" placeholder="quinta" readonly></td>\n\
                                                    \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="especial_' + i + '_lamina" name="especial[' + i + '][lamina]"  placeholder="lamina" readonly></td>\n\
                                                  \n\<td class="col-xs-1"><input class="form-control modificar anexado" type="text"  id="especial_' + i + '_sublamina" name="especial[' + i + '][sublamina]"  placeholder="sublamina" readonly></td>\n\
                                                    </tr>'
            );
    $('#tbody-seleccion-partidas').append('<tr id="' + i + '">\n\
                                                 \n\<td class="col-xs-2"><input type="text"   required  id="lote_' + i + '_nro_plano" class="modificar form-control anexado" onChange="getplanoubicacion()" readonly/></td>\n\
                                                    <td class="col-xs-2"> <input type="text" name="especial[' + i + '][nro_partida]"  id="lote_' + i + '_nro_partida" required class="modificar form-control anexado" readonly /></td>\n\
                                                            \n\<td class="col-xs-2"><div class="row col-xs-11"><input type="text"  name="especial[' + i + '][sup_mensura]"  id="lote_' + i + '_sup_terreno" required class="modificar form-control" readonly /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                         \n\<td class="col-xs-2"><div class="row col-xs-11"><input type="number" step="any" name="especial[' + i + '][sup_titulo]" value="" id="lote_' + i + '_sup_titulo"  class="form-control"/></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
                                                            \n\\n\<td class="col-xs-2"><div class="row col-xs-11"><input type="text" name="especial[' + i + '][exceso]" value="" id="lote_' + i + '_exceso"  class="form-control" /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                         \n\ <td class="col-xs-2"><div class="row col-xs-11"><input type="text" name="especial[' + i + '][sup_edificada]" id="lote_' + i + '_sup_edificada" required class="modificar form-control anexado" readonly /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\</tr>');
}

function getplanoubicacion() {
    id = $('#tbody-seleccion-partidas tr').last().attr('id');
    $('#lote_' + id).val($('#lote_' + i + '_nro_plano').val());
}




function partidas_y_superficies(data) {
    j = 0;
    $.each(data.existentes, function (i, value) {
        j++;
        $('#tbody-seleccion-partidas').append('<tr id="' + i + '">\n\
                                                 \n\<td class="col-xs-2"><input type="text"  value="' + value.plano + '" required  id="lote_' + i + '_nro_plano" class="modificar form-control anexado" readonly/></td>\n\
                                                    <td class="col-xs-2"> <input type="text" name="lote[' + i + '][nro_partida]" value="' + value.partida + '" id="lote_' + i + '_nro_partida" required class="modificar form-control anexado" readonly /></td>\n\
                                                            \n\<td class="col-xs-2"><div class="row col-xs-11"><input type="text"  name="lote[' + i + '][sup_terreno]" value="' + value.sup_terreno + '" id="lote_' + i + '_sup_terreno" required class="modificar form-control" readonly /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                         \n\<td class="col-xs-2"><div class="row col-xs-11"><input type="number" step="any" name="lote[' + i + '][sup_titulo]" value="" id="lote_' + i + '_sup_titulo"  class="form-control"/></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
                                                            \n\\n\<td class="col-xs-2"><div class="row col-xs-11"><input type="text" name="lote[' + i + '][exceso]" value="" id="lote_' + i + '_exceso"  class="form-control"/></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                         \n\ <td class="col-xs-2"><div class="row col-xs-11"><input type="text" name="lote[' + i + '][sup_edificada]" value="' + value.sup_edif_total + '" id="lote_' + i + '_sup_edificada" required class="modificar form-control anexado" readonly /></div><label class="col-xs-1 unidad">' + unidadMedida + '</label></td>\n\
\n\                                                         \n\ <input type="hidden" name="lote[' + i + '][imponible_id]" value="' + value.clave + '">\n\
                                                             \n\<input type="hidden" name="lote[' + i + '][nro_plano]" value="' + value.plano + '">\n\
                                                              \n\<input type="hidden" name="lote[' + i + '][nro_partida]" value="' + value.partida + '">\n\
\n\</tr>');
    });
    $('#cargando').hide();
    $('#formularioDocumento').css('opacity', '1').css("pointer-events","all");;
}





function calcularExeso(supTitulo, i) {
    var mensura = $('#lote_' + i + '_sup_terreno').val();
    var titulo = supTitulo;
    var exceso = parseFloat(parseFloat(mensura) - parseFloat(titulo)).toFixed(4);
    if (exceso === 'NaN')
        exceso = '';
    $('#lote_' + i + '_exceso').val(exceso.replace(",", "."));
}



function eliminar(i) {
    $('#ubicacion_' + i).remove();
    $('#' + i).remove();
}




$(document).on('change', '#departamento', function () {
    getDistritos($(this).val());
});
$(document).on('change', '#distrito', function () {
    getLocalidades($(this).val());
});
function getDeptos(dato = '') {
    $.get(path + 'getDptos/', function (datos) {
        $.each(datos, function (i, value) {
            $('#departamento').append('<option value="' + value.div_de + '">' + value.codigo_de + '-' + value.departamento + '</option>');
        });
        $('#departamento').val(dato);
    });
}

function getDistritos(numDpto, dato = '') {
    $.get(path + 'getDtos/' + numDpto, function (datos) {
        $('#distrito').html('<option value="">Seleccione Distrito.. &nbsp; &nbsp;</option>');
        $.each(datos, function (i, value) {
            $('#distrito').append('<option value="' + value.div_di + '">' + value.distrito + '</option>');
        });
        $('#distrito').val(dato);
        $('#gral_distrito').val(dato);
    });
}

function getLocalidades(dto, dato = '') {
    $('#localidad').html('<option valie="">Seleccione localidad..</option>');
    $.get(path + 'getLocalidades/' + dto, function (datos) {
        $('#localidads').html('<option valie="">Seleccione localidad..</option>');
        $.each(datos, function (i, value) {
            $('#localidad').append('<option value="' + value.div_lo + '">' + value.localidad + '</option>');
        });
        $('#localidad').val(dato);
    });
}


$('#bucarPlano').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarPlano';
    armarDatatablePlano(url, datos, true);
});
$('#bucarPartida').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarPartida/';
    armarDatatablePlano(url, datos);
});
$('#bucarMatricula').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarMatricula';
    armarDatatablePlano(url, datos);
});
$('#bucarCertificado').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarCertificado';
    armarDatatablePlano(url, datos);
});
$('#buscarUbicacion').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarUbicacion';
    armarDatatable(url, datos);
});
$('#buscarFecha').submit(function (event) {
    event.preventDefault();
    console.log($(this).serialize());
    datos = $(this).serialize();
    url = 'buscarFecha';
    armarDatatablePlano(url, datos);
});


function armarDatatablePlano(url, datos, plano = false) {
    $tabla = $('#tabla-documentos').DataTable({
        "dom": 'frtip',
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": path + url + '?' + datos,
        "columns": [
            {data: 'documento.tipo.descripcion', name: 'documento.tipo.descripcion', orderable: false, searchable: false},
            {data: 'nro_dpto', name: 'nro_dpto'},
            {data: 'nro_plano', name: 'nro_plano'},
            {data: 'nro_partida', name: 'nro_partida'},
            {data: 'documento.fecha_registro', name: 'documento.fecha_registro'},
            {data: 'vigente',
                render: function (data, type, row) {
                    switch (data) {
                        case '0' :
                            return 'No vigente';
                            break;
                        case '1' :
                            return 'Vigente';
                            break;
                        default :
                            return 'N/A';
                            break;
                    }
                }
                , name: 'vigente'},
            {data: 'accion', name: 'accion', orderable: false, searchable: false}
        ],
        drawCallback: function (settings) {
            json = $tabla.ajax.json();
            if (json.recordsTotal === 0 && plano) {
                $.get('/verificar_falta', datos, function (data) {
                    if (data) {
                        console.log(data[0]);
                        swal("El documento solicitado se encuentra en falta!", data[0].observaciones, "error");
                    }
                })
            }
        },
        "language": {
            "url": "/js/Spanish.json"
        }

    });
}




function armarDatatable(url, datos) {
    $tabla = $('#tabla-documentos').DataTable({
        "dom": 'frtip',
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": path + url + '?' + datos,

        "columns": [
            {data: 'tipo.descripcion', name: 'tipo.descripcion'},
            {data: 'documento_sat[0].nro_dpto', name: 'documentoSat.nro_dpto'},
            {data: 'documento_sat[0].nro_plano', name: 'documentoSat.nro_plano'},
            {data: 'documento_sat[0].nro_partida', name: 'documentoSat.nro_partida'},
            {data: 'fecha_registro', name: 'fecha_registro'},
            {data: 'documento_sat[0].vigente',
                render: function (data, type, row) {
                    switch (data) {
                        case '0' :
                            return 'No vigente';
                            break;
                        case '1' :
                            return 'Vigente';
                            break;
                        default :
                            return 'N/A';
                            break;
                    }
                }

                , name: 'documentoSat.vigente'},
            {data: 'accion', name: 'accion', orderable: false, searchable: false}
        ],
        "language": {
            "url": "/js/Spanish.json"
        }

    });
}




$('input').dblclick(function () {
    $(this).attr('readonly', false).css('background', 'none').css('border', 'solid 1px #d2d6de')
})

$('select').dblclick(function () {
    $(this).attr('readonly', false).css('background', 'none').css('border', 'solid 1px #d2d6de')
})



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
    inputNode=$('<input type="number" placeholder="Nro plano antecedente" name="plano_ant[]" class="form-control antecedentes" style="margin-bottom: 6%">');
    $('#grupo_antecedente').append(inputNode);
     inputNode.focus(); 
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
                        $('#pendientes').dataTable()._fnAjaxUpdate();
                    } else {

                        swal("No eliminado!", data.mensaje, "error");
                    }
                }, 'JSON');
            });
}




$('#tipo_planta').change(function () {
    if ($(this).val() > 3) {
        $('.unidad').text('Has');
    } else {
        $('.unidad').text('m²');
    }
})


function observarFicha() {
    $('#form_carga').find('#gral_fecha_registro').change(function () {
        fechaArr = $(this).val().split('-');
        fecha = fechaArr[2] + '/' + fechaArr[1] + '/' + fechaArr[0].substr(-2);
        //console.log(fecha);
        setDatosMesaFicha(fecha);
    })
    $('#form_carga').find('#gral_certificado').change(function () {
        setDatosMesaFicha(null, $(this).val());
    })

}


var bancert = 0;
function setDatosMesaFicha(fecha = null, certificado = null) {
    if (!bancert) {
        $.get(path + 'datos_certificado', {'plano': planoDesde, 'dpto': dpto, 'fecha_registro': fecha, 'certificado': certificado}, function (datos) {
            if (datos) {
                bancert = 1;
                $('#gral_fecha_registro').val(datos.fecha_registro);
                $('#gral_responsable').val(datos.Propietario);
                $('#gral_perito').val(datos.Perito);
                $('#gral_gestor').val(datos.Gestor);
                $('#gral_corrector').val(datos.Corrector);
                $('#gral_certificado').val(datos.Certificado);
            }
        }, 'JSON');
}

}


$(document).on("dblclick", '.modificar', function () {
    actualizaListaCambio(this);
});

$(document).on("change", '.modificar', function () {
    insertLogCambios(this)
});

$(document).on("change", '.select-modificar', function () {
    insertLogCambios(this, true);
});


$(document).on("dblclick", '.select-modificar', function () {
    actualizaListaCambio(this, true);
});



function actualizaListaCambio($obj, select = false) {
    var campo = $($obj).prop('id');
    var valor = (!select) ? $($obj).val() : $("#" + campo + " option:selected").text();
    console.log('cambiar campo ' + campo, valor);
    $($obj).attr('readonly', false).css('background', 'none').css('border', 'soliBorradord 1px #d2d6de');
    if (!list_modif.hasOwnProperty(campo)) {
        list_modif[campo] = valor;
        console.log(list_modif);
}
}

function insertLogCambios($obj, select = false) {
    var campo = $($obj).prop('id');
    var valor = (!select) ? $($obj).val() : $("#" + campo + " option:selected").text();
    console.log('cambiado campo ' + campo, valor);
    documento_id = $('input[name=_token]').val();
    $.get('/gurdar_log', {'documento_id': documento_id, 'campo': campo, 'val_original': list_modif[campo], 'val_cambio': valor});
}



function getCambios() {
    $.get('/get_documentos_cambio', {'documento_id': $('#documento_id').val()}, function (datos) {
        $.each(datos, function (i, v) {
            $obj = $('#' + v.campo).addClass('modificado');
            if (isNaN(v.val_cambio)) {
                $("#" + v.campo + " option:contains('" + v.val_cambio + "')").attr("selected", true);
            } else {
                $obj.val(v.val_cambio);
            }
            console.log(v.campo, v.val_original, v.val_cambio);
        })

    })
}


$(document).on('click','#cancelar',function(){
    location.reload();

});


function fecha_visible(value){
      $('#fecha_registro_visible').val(value);
    if(value===1){
        $('#uncheck').hide();
        $('#check').show();
    }
    else{
        $('#uncheck').show();
        $('#check').hide();
    }

};

  $('#form_carga').keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

  $('#form_validar').keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });




$(document).on('keyup','.antecedentes',function(e){

     if (e.which == 13) {
        agregar_antecedente();
    }
})

