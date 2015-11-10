/******************************************************/
/*    Funciones para manejo de datos de Productos     */
/******************************************************/

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
        $(this).parent().parent('tr').css("background-color", "#F7BA5B");
    }else{
        $(this).parent().parent('tr').css("background-color", "white");
    }
    //alert($(this).parent().parent('tr').children('td').length);
});

$("#asignarProductosGrid tr input:odd").click(function(){
    var keys = $('#asignarProductosGrid').yiiGridView('getSelectedRows');
    if($(this).prop("checked")){
        $(this).parent().parent('tr').css("background-color", "#F7BA5B");
    }else{
        $(this).parent().parent('tr').css("background-color", "#f9f9f9");
    }
    //alert($(this).parent().parent('tr').children('td').length);
});
