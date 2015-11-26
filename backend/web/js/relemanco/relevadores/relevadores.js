/******************************************************/
/*  Funciones para manejo de datos de Relevadores     */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    initMap();
    asignarLocalizacionClick();

});

$('label[for="relevador-id_localizacion"]').css("display", "none");
$('label[for="localizacion-nota"]').css("display", "none");

function initMap() {

    var myLatlng = {lat: -34.8059635, lng: -56.2145634};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: myLatlng
    });

    var marker = null;

    map.addListener('click', function(e) {

        var latLng = e.latLng;
        var markerLatlng = {};
        $("#localizacion-latitud").val(e.latLng.lat());
        $("#localizacion-longitud").val(e.latLng.lng());

        if(marker != null){
            marker.setMap(null);
        }
        markerLatlng = {lat: e.latLng.lat(), lng: e.latLng.lng()};
        marker = new google.maps.Marker({
            position: markerLatlng,
            animation: google.maps.Animation.DROP,
            map: map,
            title: $("#comercio-nombre").val() != "" ? $("#comercio-nombre").val() : "Nuevo Comercio"
        });
        marker.setMap(map);

    });

}

/* Funcion que envia los id de los productos seleccionados para asignarlos
al comercio elegido */
function asignarLocalizacionClick(){
    $(".btnAsignarLoc").click(function(){
        var id = $("#relevador-id").val();
        var lat = $("#localizacion-latitud").val();
        var lng = $("#localizacion-longitud").val();
        var nota = $("#relevador-id[selected]").html();

        $.ajax({
            method: "POST",
            url: rootURL + "/relevador/guardar-localizacion?id=" + id,
            dataType: "json",
            data: {"Localizacion[latitud]" : lat, "Localizacion[longitud]" : lng, "Localizacion[nota]" : nota }
        }).done(function(data){

            $.magnificPopup.open({
                items: {
                  src: '<div class="box box-warning white-popup"><h3>Se asigno la localizacion correctamente!</h3></div>',
                  type: 'inline'
                }
            });

        }).fail(function(){
            alert("Ocurrio un error al asignar la localizacion.");
        });

        return false;
    });
}
