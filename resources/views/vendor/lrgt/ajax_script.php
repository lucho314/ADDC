<script>
<?php
if (!isset($form)) {
    $form = 'form';
}
if (!isset($on_start)) {
    $on_start = false;
}
if (!isset($auto_focus)) {
    $auto_focus = true;
}
?>
    var validated = false;
    var buton_submit = false;
    var my_form = $('<?= $form ?>');
    var name_class = '<?= $request ?>';
    var on_start = '<?= $on_start ?>';
    var auto_focus = '<?= $auto_focus ?>';
        function initialize() {
            my_form.on('submit', function (e) {
                if (validated == true) {
                    var $form = $(this);
                    if ($form.data('submitted') === true) {
                        e.preventDefault();
                    } else {
                        $form.data('submitted', true);
                    }
                    return true;
                } else {
                   
                    return validate();
                }
            });

            my_form.find("input[type=submit]").on('click', function (e) {
                e.preventDefault();
               
            });

            my_form.find('.form-group').append('<div class="help-block with-errors"></div>');
//
//            my_form.find(':input').each(function () {
//                $(this).on('change', function () {
//                    validate($(this).attr('id'));
//                });
//            });

//        if (on_start == '1') {
//            validate();
//        }

            if (auto_focus) {
                $(':input:enabled:visible:first').focus();
            }
        }


        function validate(ids=null) {
            var data = my_form.serializeArray();

            data.push({name: 'class', value: name_class});

            for (var i = 0; i < data.length; i++) {
                item = data[i];
                if (item.name == '_method') {
                    data.splice(i, 1);
                }
            }
            

            $.ajax({
                url: '<?= url('validation') ?>',
                type: 'post',
                data: $.param(data),
                dataType: 'json',
                success: function (data) {    //lote[0][nro_plano]  lote.0..nro_plano. gral['plano_desde'] gral.plano_desde.
                  if (ids===null) $('.errores').html('');
                    if (data.success) {

                        $.each(my_form.serializeArray(), function (i, field) {
                            var id = $('input[name="' + field.name + '"]').attr("id");
                           //console.log('por nombre:', id);
                            $('#' + id).css('border', 'solid 1px #ccc');
                            var father = $('#' + id).parents('.panel-body');
                            father.find('.errores').html('');
//                        father.removeClass('has-error');
                            // father.addClass('has-success');
//                        father.find('.help-block').html('');
                        });

                        validated = true;
                        //if (buton_submit == true) {
                            my_form.submit();
                       // }
                    } else {
                        var campos_error = [];
                        $.each(data.errors, function (key, data) {
                            var id = key.split('.').join('_');
                            if(ids===null || ids===id){
                            var campo = $('#' + id);
                            var father = campo.parents('.panel-body');
                            console.log(data[0]);
                            $('#'+id+'_error').remove();
                            father.find('.errores').append("<li id="+id+"_error>" + data[0] + "</li>");
                            clase = campo.css("border", "solid 1px red").parents('.tabcontent').attr('id');
                             $('.' + clase).css('background', '#e66e6e');;
                           };
                            campos_error.push(id);
                        });

                        $.each(my_form.serializeArray(), function (i, field) {
                            var id = $('input[name="' + field.name + '"]').attr("id");
                            if ($.inArray(id, campos_error) === -1)
                            {
                                //var father = $('#' + field.name).parent('.form-group');

                                //console.log('aca', id);
                                $('#' + id).css('border', 'solid 1px #ccc');
                               $('#'+id+'_error').remove();
//                            father.removeClass('has-error');
//                            father.addClass('has-success');
//                            father.find('.help-block').html('');
                            }
                        });

                        validated = false;
                        buton_submit = false;
                    }
                },
                error: function (xhr) {
                    console.log(xhr.status);
                }
            });
            return false;
        }
</script>