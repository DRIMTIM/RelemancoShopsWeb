/******************************************************/
/*    Funciones para manejo de datos de Productos     */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    $('.select-on-check-all').val(0);
    $("label[for=comercio-id]").css("display", "none");
    $(".summary").css("float", "right");
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
$("#asignarProductosGrid tr input[type=checkbox]:even").click(function(){

    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#FAD9A4");
    }else{
        $(this).parent().parent('tr').css("background-color", "white");
    }
    //alert($(this).parent().parent('tr').children('td').length);
});

$("#asignarProductosGrid tr input[type=checkbox]:odd").click(function(){

    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#FAD9A4");
    }else{
        $(this).parent().parent('tr').css("background-color", "#f9f9f9");
    }
    /*$(this).parent().parent('tr').children('td').each(function(){

    });*/
});

/* Funcion que envia los id de los productos seleccionados para asignarlos
al comercio elegido */
function asignarProductosClick(){
    $(".btnAsignar").click(function(){
        var id = $("#comercio-id").val();
        var productos = $('#asignarProductosGrid').yiiGridView('getSelectedRows');

        $.ajax({
            method: "POST",
            url: rootURL + "/comercio/guardar-productos",
            dataType: "json",
            data: { id_comercio : id, "productos[]" : productos}
        }).done(function(data){

            $.magnificPopup.open({
                items: {
                  src: '<div class="box box-warning white-popup"><h3>Se asignaron los productos correctamente!</h3></div>',
                  type: 'inline'
                }
            });

        }).fail(function(){
            alert("Ocurrio un error al asignar el/los productos seleccionados.");
        });

        return false;
    });
}

/* Funcion para uncheckear toda la tabla de productos */
function deSeleccionarProductos(){
    $("#asignarProductosGrid input[type=checkbox]:odd").each(function(){
        if($(this).prop("checked")){
            $(this).click();
        }
    });
    $("#asignarProductosGrid input[type=checkbox]:even").each(function(){
        if($(this).prop("checked")){
            $(this).click();
        }
    });
}

/* Function para seleccionar los productos de un comercio */
function seleccionarProductos(json){
    for(var i = 0; i < json.length; i++){
        $("#asignarProductosGrid input[value='" +  json[i].id + "']").click();
    }
}

/* Function para seleccionar los productos de un comercio */
function obtenerProductos(){
    var id = $("#comercio-id").val();
    deSeleccionarProductos();
    $.post(rootURL + "/comercio/obtener-productos", { id_comercio : id }, function(json){
        seleccionarProductos(json);
        console.log(json);
    });

}

$("#comercio-id").change(function(){
    if($(this).val() == ""){
        deSeleccionarProductos();
    }else{
        obtenerProductos();
    }
});
