/******************************************************/
/*    Funciones para manejo de datos de Productos     */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    $("label[for=comercio-id]").css("display", "none");
    asignarProductosClick();

});

function mostrarMiniaturaImagen(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.imagenProducto').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#producto-imagefile").change(function(){
    $("#uploadFile").val(this.value.split("\\")[2]);
    mostrarMiniaturaImagen(this);
});


/************************************************/
/************** Asignar Productos  **************/
/************************************************/

// keys is an array consisting of the keys associated with the selected rows
$("#asignarProductosGrid tr input:even").click(function(){
    var keys = $('#asignarProductosGrid').yiiGridView('getSelectedRows');
    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#FAD9A4");
    }else{
        $(this).parent().parent('tr').css("background-color", "white");
    }
    //alert($(this).parent().parent('tr').children('td').length);
});

$("#asignarProductosGrid tr input:odd").click(function(){
    var keys = $('#asignarProductosGrid').yiiGridView('getSelectedRows');
    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#FAD9A4");
    }else{
        $(this).parent().parent('tr').css("background-color", "#f9f9f9");
    }
    $(this).parent().parent('tr').children('td').each(function(){

    });
});

/* Funcion que envia los id de los productos seleccionados para asignarlos
al comercio elegido */
function asignarProductosClick(){
    $(".btnAsignar").click(function(){
        var id = $("#comercio-id").val();
        var productos = $('#asignarProductosGrid').yiiGridView('getSelectedRows');

        $.post(rootURL + "/comercio/guardar-productos", { id_comercio : id, "productos[]" : productos} ,
        function(data){
            alert(data);
        }).fail(function(){
            alert("Ocurrio un error al asignar el/los productos seleccionados.");
        });
    });
}
