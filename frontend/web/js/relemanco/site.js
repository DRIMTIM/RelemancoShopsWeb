/******************************************************/
/*     Funciones para manejo de datos del home        */
/******************************************************/

var endpoint = 'http://localhost/RelemancoShopsWeb/api/web/v1/';
var rootURL = "/RelemancoShopsWeb/frontend/web";
var comercioMarkers = [];
var markersColors = ["blue", "brown", "green", "orange", "paleblue", "yellow", "pink",
                     "purple", "red", "darkgreen"];
var markersName = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "M", "N",
                    "O", "P", "Q", "R", "S", "T", "X"];

var map = null;


$( document ).ready(function() {

    // localizarComercios();
    initComerciosMap();
    getRutasHistorico();

});


function getRutasHistorico() {

    var user = $('#perfil-usuario').data('user');
    if(user) {
        $.ajax({
            method: "GET",
            url: endpoint + 'rutas/obtenerhistoricorutas',
            data: {'id_relevador': user-1},
            dataType: "json",
            contentType: 'application/json'
        }).done(function(data){
            var rutas = jQuery.parseJSON(data);
            dibujarTablaRutas(rutas, 'tabla-body');
        }).fail(function(response){
            alert(response.status);
        });
    }

}

function cambiarRutas() {
    var id = this.id;
    var ruta = $('#'+id).data('ruta');

    clearComercios(comercioMarkers);
    comercioMarkers.length = 0;

    if(ruta && ruta.comercios && ruta.comercios.length > 0) {
        var comercios = ruta.comercios;

        geoService.clearRoutes(map);
        for (var i = 0; i < comercios.length; i++) {
            addComercio(comercios[i], 200, map);
        }
        geoService.createRoutes(comercios, map);
    }

}

function dibujarTablaRutas(rutas, idTableBody) {

    if(rutas.length > 0 ){
        var tabla =  $('#'+idTableBody);
        rutas.forEach(function (val) {
            tabla.append('<tr id="' + val.id + '"><td>' + val.fecha_asignada + '</td><td>' + val.estado.nombre + '</td></tr>');
            var tr = $('#' + val.id);
            tr.on('click', cambiarRutas);
            tr.attr('id', val.id);
            tr.data('ruta', val);
        });
    }
}


/**
 * Returns a random integer between min (inclusive) and max (inclusive)
 * Using Math.round() will give you a non-uniform distribution!
 */
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function initComerciosMap() {

    var myLatlng = {lat: -34.8059635, lng: -56.2145634};
    map = new google.maps.Map(document.getElementById('mapa-comercios'), {
        zoom: 15,
        center: myLatlng
    });

}

function dropComercios(comercios, map) {
    clearComercios(comercioMarkers);
    for (var i = 0; i < comercios.length; i++) {
        addComercio(comercios[i], 2000, map);
    }
}

function clearComercios(comercios) {
  for (var i = 0; i < comercios.length; i++) {
    comercios[i].setMap(null);
  }
}

function markerAnimation(marker){
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

/* Funcion para genera la lista de comercios en la ventana de informacion del
    Comercio */
function generarInfoListaProductoComercio(productos){
    if(productos != null){
        var lista = "<ul>";
        for (var i = 0; i < productos.length; i++){
            lista += "<li>" + productos[i].nombre + "</li>";
        }
        lista += "</ul>";
        return lista;
    }
    return "<li>Este comercio no tiene productos asignados.</li>";
}

function generarEnlaceComecio(comercio){
    return "&nbsp;&nbsp;&nbsp;<a href='" + rootURL  + '/comercio/view?id=' + comercio.id +
                                    "'><i class='fa fa-eye'>&nbsp;</i>Ver Comercio</a>";
}

function generarInfoComercio(comercio){
    if(comercio != null){
        var info = "<h4>" + comercio.nombre + "</h4>";
        info += "<hr/>";
        info += generarInfoListaProductoComercio(comercio.productos);
        info += "<hr/>";
        info += generarEnlaceComecio(comercio);
        return info;
    }
    return null;
}

function addComercio(comercio, timeout, map) {

    var loc = comercio.localizacion;
    var position = { lat : Number(loc.latitud), lng: Number(loc.longitud) };
    var comercioMark = null;

    comercioMark = new google.maps.Marker({
        position: position,
        map: map,
        animation: google.maps.Animation.DROP,
        title: comercio.nombre,
        icon: rootURL + "/img/GMapsMarkers/" +
                markersColors[getRandomInt(0,9)] + "_Marker" +
                markersName[getRandomInt(0,19)] + ".png"
    });

    var infowindow = new google.maps.InfoWindow({
        content: generarInfoComercio(comercio)
    });

    comercioMark.addListener('click', function() {
        infowindow.addListener('closeclick', function(){
            comercioMark.setAnimation(null);
        });
        markerAnimation(this);
        infowindow.open(map, this);
    });

    comercioMarkers.push(comercioMark);
}

var geoService = {

    createRoutes: function(markers, map) {

        var directionsService = new google.maps.DirectionsService();
        map._directions = [];
        function renderDirections(result) {
            var directionsRenderer = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
            directionsRenderer.setMap(map);
            directionsRenderer.setDirections(result);
            map._directions.push(directionsRenderer);
        }

        function requestDirections(start, end) {
            directionsService.route({
                origin: start,
                destination: end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC
            }, function (result, status) {
                renderDirections(result);
            });
        }

        for (var i = 0; i < markers.length; i++) {
            if (i < markers.length - 1) {
                var origen = {lat: Number(markers[i].localizacion.latitud), lng: Number(markers[i].localizacion.longitud)};
                var destino = {lat: Number(markers[i + 1].localizacion.latitud), lng: Number(markers[i + 1].localizacion.longitud)};
                requestDirections(origen, destino);
            }
        }
    },

    clearRoutes: function (Gmap) {
        if (Gmap._directions && Gmap._directions.length > 0) {
            var directions = Gmap._directions;
            directions.forEach(function (val) {
                val.setMap(null);
            });
        }
    }

};