<script>
    $('.clik').eq(0).css('background-color', '#ccc');
    indice = 0;
    seccion = 'generales';
    function openSearch(index, city) {
        indice = index;
        seccion = city;
        $('#maximizar').hide();
        $('#minimizar').show();
        $('#objeto_imagen').css('height', mitadAlto);
        $('.clik').css('background-color', '');
        $('.clik').eq(index).css('background-color', '#ccc');

        $('.tabcontent').hide();
        $('#' + city).show();
    }
    ;
    $('form').submit(function (e) {

        $('#submit').click();
    })

    function ocultar() {
        tamanio = parseInt(alto) - (parseInt(alto) * 0.3);
        $('.tabcontent').hide();
        $('#objeto_imagen').css('height', tamanio);
        $('#maximizar').show();
        $('#minimizar').hide();
    }

    function desocultar() {
        openSearch(indice, seccion);
    }


</script>

