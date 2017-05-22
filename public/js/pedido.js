

function abrir_modal_pedido(){  
    $('#mensaje_pedido').hide();
    $('#realizar_pedido').modal('toggle');
    
}


$('#form_pedido').submit(function(e){
    e.preventDefault();
    
    var datos=$(this).serialize();
    var url=$(this).attr('action');
    
    $.post(url,datos,function(data){
        if(data.respuesta){
            swal("Realizado!", "El pedido se registró correctamente!", "success");
            $('#realizar_pedido').modal('toggle');
            $('#reset').click();
        }
        else{
             swal("Error!", "Surgió un error al cargar la solicitud,intente nuevamente!", "error");
        };
       }).fail(function(data){
           swal("Error!", "Surgió un error al cargar la solicitud,intente nuevamente!", "error");
       });
});


