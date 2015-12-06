/******************************************************/
/*     Funciones para manejo de datos del home        */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/frontend/web";
var comercioMarkers = [];
var markersColors = ["blue", "brown", "green", "orange", "paleblue", "yellow", "pink",
                     "purple", "red", "darkgreen"];
var markersName = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "M", "N",
                    "O", "P", "Q", "R", "S", "T", "X"];


$( document ).ready(function() {

    // localizarComercios();

});

/**
 * Returns a random integer between min (inclusive) and max (inclusive)
 * Using Math.round() will give you a non-uniform distribution!
 */
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function initComerciosMap(comercios) {

    var myLatlng = {lat: -34.8059635, lng: -56.2145634};

    var map = new google.maps.Map(document.getElementById('mapa-comercios'), {
        zoom: 11,
        center: myLatlng
    });

    dropComercios(comercios, map);

}

/* Obtener todos los comercios para ubicar en la mapa */
function localizarComercios(){

    $.ajax({
        method: "GET",
        url: rootURL + "/comercio/obtener-comercios",
        dataType: "json",
    }).done(function(data){

        console.log(data);
        initComerciosMap(data);

    }).fail(function(){
        alert("Ocurrio un error al ubicar los comercios en el mapa.");
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
  comercios = [];
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

    window.setTimeout(function() {
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
    }, timeout);
}
