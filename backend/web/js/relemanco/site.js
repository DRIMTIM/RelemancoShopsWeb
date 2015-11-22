/******************************************************/
/*     Funciones para manejo de datos del home        */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";
var comercioMarkers = [];

$( document ).ready(function() {

    localizarComercios();

});

function initComerciosMap(comercios) {

    var myLatlng = {lat: -34.8059635, lng: -56.2145634};

    var map = new google.maps.Map(document.getElementById('mapa-comercios'), {
        zoom: 11,
        center: myLatlng
    });

    dropComercios(comercios, map);

    map.addListener('click', function(e) {



    });

}

/* Obtener todos los comercios para ubicar en la mapa */
function localizarComercios(){

    $.ajax({
        method: "GET",
        url: rootURL + "/comercio/obtener-comercios",
        dataType: "json",
    }).done(function(data){

        console.log(data);
        // $.magnificPopup.open({
        //     items: {
        //       src: '<div class="box box-warning white-popup"><h3>Se asignaron los productos correctamente!</h3></div>',
        //       type: 'inline'
        //     }
        // });

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

function addComercio(comercio, timeout, map) {
    var loc = comercio.localizacion;
    var position = { lat : Number(loc.latitud), lng: Number(loc.longitud) };

    window.setTimeout(function() {
        comercioMarkers.push(new google.maps.Marker({
          position: position,
          map: map,
          animation: google.maps.Animation.DROP
        }));
    }, timeout);
}
