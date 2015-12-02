/******************************************************/
/*     Funciones para manejo de datos de rutas        */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";
var relevadoresMarkers = [];
var relevadores = null;
var radioRelevador = null;
var relevadoresMap = null;
var markersColors = ["blue", "brown", "green", "orange", "paleblue", "yellow", "pink",
                     "purple", "red", "darkgreen"];
var googleMapCircle = null;

$( document ).ready(function() {
    localizarRelevadores();
    loadEventHandlers();
});

/**
 * Returns a random integer between min (inclusive) and max (inclusive)
 * Using Math.round() will give you a non-uniform distribution!
 */
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function localizarRelevadores(){
    var checkboxes = $(':checkbox');
    var relevadores = new Array();
    for(var i = 0; i < checkboxes.length; i++){
        relevadores.push(checkboxes[i].value);
    }
    $.ajax({
        method: "POST",
        url: rootURL + "/rutas/buscar-relevadores-for-map",
        dataType: "json",
        data: 'relevadores_disponibles=' + JSON.stringify(relevadores)
    }).done(function(data){
        console.log(data);
        initRelevadoresMap(data);
    }).fail(function(error){
        console.log(error);
        alert("Ocurrio un error al ubicar los relevadores en el mapa.");
    });

}

function initRelevadoresMap(data) {
    relevadores = data.relevadores;
    radioRelevador = data.radioRelevador;
    var localizacionCentral = null;
    if(data.relevadores.length > 0){
        localizacionCentral = {lat: parseFloat(data.relevadores[0].idLocalizacion.latitud), lng: parseFloat(data.relevadores[0].idLocalizacion.longitud) }
    }else{
        localizacionCentral = {lat: -34.8059635, lng: -56.2145634};
    }
    var map = new google.maps.Map(document.getElementById('mapa-ruta'), {
        zoom: 14,
        center: localizacionCentral
    });
    relevadoresMap = map;
    dropRelevadores(data, map);
}

function dropRelevadores(data, map) {
    clearRelevadores(relevadoresMarkers);
    for (var i = 0; i < data.relevadores.length; i++) {
        addRelevador(data.relevadores[i], data.radioRelevador,2000, map);
    }
}

function clearRelevadores(relevadoresMarkers) {
    for (var i = 0; i < relevadoresMarkers.length; i++) {
      relevadoresMarkers[i].setMap(null);
    }
    relevadoresMarkers = [];
}

function markerAnimation(marker){
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

function generarEnlaceRelevador(user){
    return "&nbsp;&nbsp;&nbsp;<a href='" + rootURL  + '/user/admin/update?id=' + user.id +
        "'><i class='fa fa-eye'>&nbsp;</i>Ver Relevador</a>";
}

function generarInfoRelevador(relevador){
    if(relevador != null){
        var info = "<h4>" + relevador.user.username + "</h4>";
        info += "<hr/>";
        info += generarEnlaceRelevador(relevador.user);
        return info;
    }
    return null;
}

function addRelevador(relevador, radio,timeout, map) {
    var position = { lat : Number(relevador.idLocalizacion.latitud), lng: Number(relevador.idLocalizacion.longitud) };
    var relevadorMark = null;
    var color = markersColors[getRandomInt(0,9)];
    new google.maps.Circle({
        strokeColor: 'red',
        strokeOpacity: 0.5,
        strokeWeight: 3,
        fillColor: color,
        fillOpacity: 0.1,
        map: map,
        center: position,
        radius: radio
    });
    window.setTimeout(function() {
        relevadorMark = new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP,
            title: relevador.user.username,
            icon: rootURL + "/img/GMapsMarkers/" +
            color + "_MarkerR.png"
        });

        var infowindow = new google.maps.InfoWindow({
            content: generarInfoRelevador(relevador, relevador.user)
        });

        relevadorMark.addListener('click', function() {
            infowindow.addListener('closeclick', function(){
                relevadorMark.setAnimation(null);
            });
            markerAnimation(this);
            infowindow.open(map, this);
        });

        relevadoresMarkers.push(relevadorMark);
    }, timeout);
}

function loadEventHandlers(){
    var checkboxes = $(":checkbox");
    for(var i = 0; i < checkboxes.length; i++){
        checkboxes[i].onchange = function(){
            var idRelevador = this.value;
            clearOtherChecks(idRelevador);
            if(googleMapCircle !== null){
                googleMapCircle.setMap(null);
            }
            if(this.checked === true) {
                googleMapCircle = new google.maps.Circle({
                    strokeColor: 'red',
                    strokeOpacity: 0.5,
                    strokeWeight: 3,
                    fillColor: "green",
                    fillOpacity: 0.3,
                    map: relevadoresMap,
                    center: getLocalizacionRelevador(idRelevador),
                    radius: radioRelevador
                });
                relevadoresMap.setCenter(getLocalizacionRelevador(idRelevador));
            }
        };
    }
}

function clearOtherChecks(idRelevador){
    var checkboxes = $(":checkbox");
    for(var i = 0; i < checkboxes.length; i++){
        var idCheck = checkboxes[i].value;
        if(checkboxes[i].checked === true &&
            idCheck !== idRelevador){
            checkboxes[i].checked = false;
        }
    }
}

function getLocalizacionRelevador(idRelevador){
    for(var i = 0; i < relevadores.length; i++){
        if(relevadores[i].id === idRelevador){
            return { lat: parseFloat(relevadores[i].idLocalizacion.latitud), lng: parseFloat(relevadores[i].idLocalizacion.longitud) };
        }
    }
    return null;
}
