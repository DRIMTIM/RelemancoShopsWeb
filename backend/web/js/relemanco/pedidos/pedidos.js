/******************************************************/
/*    Funciones para manejo de datos de Pedidos       */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    $("label[for=pedido-fecha_realizado]").remove();
    $("label[for=pedido-id_comercio]").remove();
    $(".summary").css("float", "right");
    $("#pedido-fecha_realizado").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
    $(".cantidad").inputmask();
    confirmarPedidoClick();


});


/************************************************/
/*************** Confirmar Pedido  **************/
/************************************************/

// keys is an array consisting of the keys associated with the selected rows
$("#armarPedidoGrid tr input[type=checkbox]:even").click(function(){
    var keys = $('#armarPedidoGrid').yiiGridView('getSelectedRows');
    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#FAD9A4");
    }else{
        $(this).parent().parent('tr').css("background-color", "white");
    }
    //alert($(this).parent().parent('tr').children('td').length);
});

$("#armarPedidoGrid tr input[type=checkbox]:odd").click(function(){
    var keys = $('#armarPedidoGrid').yiiGridView('getSelectedRows');
    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#FAD9A4");
    }else{
        $(this).parent().parent('tr').css("background-color", "#f9f9f9");
    }
    /*$(this).parent().parent('tr').children('td').each(function(){

    });*/
});

function validarPedido(){

    var keys = $('#armarPedidoGrid').yiiGridView('getSelectedRows');
    var valido = false;

    if(keys.length != 0){
        for(var key in keys){
            var cantidad = $("input[value=" + keys[key] + "]").parent().parent('tr').children('td').last().children('input').val();
            valido = cantidad != "" || cantidad != 0;
        }
        if(!valido){
            $.magnificPopup.open({
                items: {
                  src: '<div class="box box-warning white-popup"><h3>Verifique que la cantidades de los productos no sean nulas...</h3></div>',
                  type: 'inline'
                }
            });
        }
    }else{
        $.magnificPopup.open({
            items: {
              src: '<div class="box box-warning white-popup"><h3>Por favor ingrese un por los menos un Producto hdp!</h3></div>',
              type: 'inline'
            }
        });
    }

    return valido && validarFecha();

}

function validarFecha(){
    if($("#pedido-fecha_realizado").val() == "" || $("#pedido-fecha_realizado").val() == null){
        $.magnificPopup.open({
            items: {
              src: '<div class="box box-warning white-popup"><h3>Por favor ingrese una fecha!</h3></div>',
              type: 'inline'
            }
        });
        return false;
    }
    return true;
}

/* Funcion que envia los id de los productos seleccionados para asignarlos
al comercio elegido */
function confirmarPedidoClick(){
    $("#btnConfirmar").click(function(){
        var id = $("#pedido-id_comercio").val();
        var fecha = $("#pedido-fecha_realizado").val();
        var productos = $('#armarPedidoGrid').yiiGridView('getSelectedRows');
        var productosCant = [];
        var i = 0;

        $('.cantidad').each(function(){
            if($(this).val() != '' && $(this).val() != null){
                productosCant[i] = $(this).val();
                i++;
            }
        });

        if(validarPedido()){

            $.ajax({
                method: "POST",
                url: rootURL + "/pedido/confirmar-pedido",
                dataType: "json",
                data: { id_comercio : id, "productos[]" : productos, "cantidades[]" : productosCant, "fecha" : fecha }
            }).done(function(data){
                console.log(data);

                $.magnificPopup.open({
                    items: {
                      src: '<div class="box box-warning white-popup"><h3>Se confirmo el pedido correctamente!</h3></div>',
                      type: 'inline'
                    }
                });

                setTimeout(function(){
                    window.location.replace(rootURL + "/pedido");
                }, 1500);

            }).fail(function(){
                alert("Ocurrio un error al realizar el pedido.");
            });

        }

        return false;
    });
}
