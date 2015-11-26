/******************************************************/
/*  Funciones para manejo de datos de Comercios       */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    initMap();
    // obtenerComercios();

});

$(".summary").css("float", "right");
$('label[for="comercio-id_localizacion"]').css("display", "none");
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
