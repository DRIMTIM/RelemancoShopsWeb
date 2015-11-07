/******************************************************/
/*  Funciones para manejo del mapa de Localizaciones  */
/******************************************************/

$( document ).ready(function() {

    initMap();

});

function initMap() {
    var myLatlng = {lat: -34.8059635, lng: -56.2145634};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: myLatlng
    });

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'Click to zoom'
    });

    map.addListener('click', function(e) {
        // 3 seconds after the center of the map has changed, pan back to the
        // marker.
        var latLng = e.latLng;
        $("#localizacion-latitud").val(e.latLng.lat());
        $("#localizacion-longitud").val(e.latLng.lng());

        var showMarker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: 'Fuck the King!!'
        });

    });

    marker.addListener('click', function() {
        map.setZoom(8);
        map.setCenter(marker.getPosition());

    });

}
