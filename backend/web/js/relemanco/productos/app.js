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
    mostrarMiniaturaImagen(this);
});
