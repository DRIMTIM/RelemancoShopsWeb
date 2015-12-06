/******************************************************/
/*     Funciones para manejo de datos de rutas        */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";
var comercioMarkers = [];
var relevadorMarkers = [];
var markersColors = ["blue", "brown", "green", "orange", "paleblue", "yellow", "pink",
                     "purple", "red", "darkgreen"];
var markersName = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "M", "N",
                    "O", "P", "Q", "S", "T", "X"];

$( document ).ready(function() {
    localizarComercios();
    loadRoutePointsCheckEventHandlers();
    $('#_id_form_step_2').submit(function(){loadDataBeforeSubmit();});
});

/**
 * Returns a random integer between min (inclusive) and max (inclusive)
 * Using Math.round() will give you a non-uniform distribution!
 */
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function initComerciosMap(data) {
    var localizacionRelevador = data.localizacionRelevador;
    var relevadorLatLong = {lat: localizacionRelevador.latitud, lng: localizacionRelevador.longitud};
    var map = new google.maps.Map(document.getElementById('mapa-ruta'), {
        zoom: 14,
        center: relevadorLatLong
    });
    routeMap = map;
    dropRelevador(data, map);
    dropComercios(data.comercios, map);
}

function dropRelevador(data, map){
    var relevadorLatLong = {lat: data.localizacionRelevador.latitud, lng: data.localizacionRelevador.longitud};
    addRelevador(data, 2000, map);
    return new google.maps.Circle({
        strokeColor: 'red',
        strokeOpacity: 0.5,
        strokeWeight: 3,
        fillColor: 'blue',
        fillOpacity: 0.1,
        map: map,
        center: relevadorLatLong,
        radius: data.radioRelevador
    });
}

/* Obtener todos los comercios para ubicar en la mapa */
function localizarComercios(){

    var checkboxes = $(':checkbox');
    var comercios = new Array();
    for(var i = 0; i < checkboxes.length; i++){
        comercios.push(checkboxes[i].value);
    }
    console.log(comercios);
    $.ajax({
        method: "POST",
        url: rootURL + "/rutas/buscar-comercios-seleccionados",
        dataType: "json",
        data: 'comercios_seleccionados=' + JSON.stringify(comercios)
    }).done(function(data){
        console.log(data);
        initComerciosMap(data);
        comerciosDisponibles = data.comercios;

    }).fail(function(error){
        console.log(error);
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

/* Funcion para genera la lista de comercios en la ventana de informacion del Comercio */

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

function generarEnlaceComecio(comercio){
    return "&nbsp;&nbsp;&nbsp;<a href='" + rootURL  + '/comercio/view?id=' + comercio.id +
        "'><i class='fa fa-eye'>&nbsp;</i>Ver Comercio</a>";
}

function generarEnlaceRelevador(user){
    return "&nbsp;&nbsp;&nbsp;<a href='" + rootURL  + '/user/admin/update?id=' + user.id +
        "'><i class='fa fa-eye'>&nbsp;</i>Ver Relevador</a>";
}

function generarInfoRelevador(relevador, user){
    if(relevador != null && user != null){
        var info = "<h4>" + user.username + "</h4>";
        info += "<hr/>";
        info += generarEnlaceRelevador(user);
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
                    markersColors[getRandomInt(0,9)] + "_MarkerC.png"
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

function addRelevador(data, timeout, map) {
    var position = { lat : Number(data.localizacionRelevador.latitud), lng: Number(data.localizacionRelevador.longitud) };
    localizacionRelevador = position;
    var relevadorMark = null;

    window.setTimeout(function() {
        relevadorMark = new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP,
            title: data.relevador.username,
            icon: rootURL + "/img/GMapsMarkers/" +
            markersColors[getRandomInt(0,9)] + "_MarkerR.png"
        });

        var infowindow = new google.maps.InfoWindow({
            content: generarInfoRelevador(data.relevador, data.user)
        });

        relevadorMark.addListener('click', function() {
            infowindow.addListener('closeclick', function(){
                relevadorMark.setAnimation(null);
            });
            markerAnimation(this);
            infowindow.open(map, this);
        });

        relevadorMarkers.push(relevadorMark);
    }, timeout);
}

//Comienza el codigo para el armado de rutas en pantalla

var routeMap = null;
var routePoints = [];
var comerciosDisponibles = [];
var directionsDisplay = null;
var directionsService = new google.maps.DirectionsService();
var localizacionRelevador = null;
var maximoKilometrosRecorrer = null;

function getComercioDisponible(idComercio){
    for(var i = 0; i < comerciosDisponibles.length; i++){
        if(comerciosDisponibles[i].id === idComercio){
            return comerciosDisponibles[i];
        }
    }
    return null;
}

function RutePoint(comercio, localizacion){
    this.comercio = comercio;
    this.localizacion = localizacion;
}

function existeEnRuta(idComercio){
    if(idComercio){
        for(var i = 0; i < routePoints.length; i++){
            var routePoint = routePoints[i];
            if(routePoint.comercio.id === idComercio)
                return true;
        }
        return false;
    }
    return null;
}

function updateRoutePoint(idComercio){
    if(existeEnRuta(idComercio) === false) {
        var comercio = getComercioDisponible(idComercio);
        var rutePoint = new RutePoint(comercio, {
            lat: parseFloat(comercio.localizacion.latitud),
            lng: parseFloat(comercio.localizacion.longitud)
        });
        routePoints.push(rutePoint);
        updateMapWithRoute();
    }else{
        removeRoutePoint(idComercio);
        if(routePoints.length > 0) {
            updateMapWithRoute();
        }else{
            localizarComercios();
        }
    }
}

function removeRoutePoint(idComercio){
    if(idComercio){
        for(var i = 0; i < routePoints.length; i++){
            var routePoint = routePoints[i];
            if(idComercio === routePoint.comercio.id)
                routePoints.splice(i, 1);
        }
    }
}

function updateMapWithRoute(){
    if(directionsDisplay === null)
        directionsDisplay = new google.maps.DirectionsRenderer();
    directionsDisplay.setMap(routeMap);
    directionsDisplay.setOptions({
        suppressMarkers: true,
        polylineOptions: {
            strokeWeight: 2,
            strokeOpacity: 0.8,
            strokeColor:  'green'
        }
    });
    var ruteRequest = new RuteRequest();
    directionsService.route(ruteRequest, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
        }
    });
}

function getDestination(){
    if(routePoints.length > 0){
        return routePoints[routePoints.length - 1].localizacion;
    }
    return null;
}

function getWayPoints(){
    waypoints = [];
    if(routePoints.length > 0){
        for(var i = 0; i < routePoints.length - 1; i++){
            var waypoint = {
                location: routePoints[i].localizacion,
                stopover: true
            };
            waypoints.push(waypoint);
        }
    }
    return waypoints;
}

function clearRoutePoints(){
    if(routePoints.length > 0){
        for(var i = 0; i <= routePoints.length; i++){
            routePoints.pop();
        }
    }
}

function RuteRequest(){
    return {
        origin: localizacionRelevador,
        destination: getDestination(),
        provideRouteAlternatives: false,
        waypoints: getWayPoints(),
        travelMode: google.maps.TravelMode.WALKING,
        unitSystem: google.maps.UnitSystem.METRIC
    };
}

function loadRoutePointsCheckEventHandlers(){
    var checkboxes = $(":checkbox");
    for(var i = 0; i < checkboxes.length; i++){
        checkboxes[i].onchange = function(){
            var idComercio = this.value;
            updateRoutePoint(idComercio);
            updateMapWithRoute();
        };
    }
}

function loadDataBeforeSubmit(){
    if(routePoints !== null && routePoints.length > 0){
        var listaOrdenadaComercios = [];
        for(var i = 0; i < routePoints.length; i++){
            var idComercio = routePoints[i].comercio.id;
            listaOrdenadaComercios.push(idComercio);
        }
        $("#ruta_comercios").val(JSON.stringify(listaOrdenadaComercios));
    }else{
        $("#ruta_comercios").val(null);
    }
}

function setCheckComercios(comercios){
    if(comercios){
        var checkboxes = $(':checkbox');
        for(var i = 0; i < checkboxes.length; i++){
            var idComercio = checkboxes[i].value;
            if(isCheckForSet(idComercio, comercios)){
                checkboxes[i].checked = true;
            }else{
                checkboxes[i].checked = false;
            }
        }
    }
}

function isCheckForSet(idComercio, comercios){
    if(idComercio && comercios){
        for(var i = 0; i < comercios.length; i++){
            var id = comercios[i].id;
            if(id === idComercio){
                return true;
            }
        }
    }
    return false;
}

function loadBestRoute(){
    $.ajax({
        method: "POST",
        url: rootURL + "/rutas/load-best-route",
        dataType: "json",
        data: 'comercios_disponibles=' + JSON.stringify(comerciosDisponibles) +
            '&localizacion_relevador=' + JSON.stringify({ "latitud" : localizacionRelevador['lat'], "longitud" : localizacionRelevador['lng']})
    }).done(function(data){
        if(data){
            clearRoutePoints();
            setCheckComercios(data.comercios);
            for(var i = 0; i < data.comercios.length; i++){
                updateRoutePoint(data.comercios[i].id);
            }
            $("#_cartel_info").show();
        }
    }).fail(function(error){
        console.log(error);
        alert('Ocurrió un error al generar la ruta optima para el recorrido!');
    });
}