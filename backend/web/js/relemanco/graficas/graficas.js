/******************************************************/
/*    Funciones para manejo de datos de Graficas      */
/******************************************************/

var rootURL = "/RelemancoShopsWeb/backend/web";

$( document ).ready(function() {

    $("label[for=comercio-id]").css("display", "none");
    obtenerProductosMasVendidosComecio();
    obtenerCantidadPedidosComercios();

});

function obtenerProductosMasVendidosComecio(){

    if($('#comercio-id').val() == 0){
        $.magnificPopup.open({
            items: {
              src: '<div class="box box-warning white-popup"><h3>Seleccione un comercio, para sacar sus estadisticas...</h3></div>',
              type: 'inline'
            }
        });
    }

    $('#comercio-id').change(function(){
        var id = $('#comercio-id').val();

        $.ajax({
            method: "POST",
            url: rootURL + "/grafica/grafica-barras-ventas",
            dataType: "json",
            data: { id_comercio : id }
        }).done(function(data){

            console.log(data);
            dibujarGraficaBarrasProductosVendidos(data.length == 0 ? null : data);

        }).fail(function(){
            $.magnificPopup.open({
                items: {
                  src: '<div class="box box-warning white-popup"><h3>Ocurrio un error al obtener datos de graficas.</h3></div>',
                  type: 'inline'
                }
            });
        });

    });

}

function obtenerCantidadPedidosComercios(){

    $.ajax({
        method: "GET",
        url: rootURL + "/grafica/grafica-barras-pedidos",
        dataType: "json",
    }).done(function(data){

        console.log(data);
        dibujarGraficaBarrasPedidosComercios(data.length == 0 ? null : data);

    }).fail(function(){
        $.magnificPopup.open({
            items: {
              src: '<div class="box box-warning white-popup"><h3>Ocurrio un error al obtener datos de graficas.</h3></div>',
              type: 'inline'
            }
        });
    });

}

function generarDatosGraficaBarrasPedidos(data){

    var result = [];

    if(data != null){
        for (var i = 0; i < data.length; i++){
            var dataJSON = {};
            dataJSON.name = data[i].nombre;
            dataJSON.y = Number(data[i].cantidad);
            dataJSON.drilldown = null;
            console.log(dataJSON);
            result.push(dataJSON);
        }
    }

    return result;

}

function generarDatosGraficaBarrasVentas(data){

    var result = [];

    if(data != null){
        for (var i = 0; i < data.length; i++){
            var dataJSON = {};
            dataJSON.name = data[i].nombre;
            dataJSON.y = Number(data[i].ventas);
            dataJSON.drilldown = null;
            console.log(dataJSON);
            result.push(dataJSON);
        }
    }

    return result;

}

/* Funciones para dibujar las graficas. Libreria : www.highcharts.com (un fuego!!) */
function dibujarGraficaBarrasProductosVendidos(data){
    // Create the chart
    $('#divGraficaProductos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Productos mas Vendidos 2015'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Cantidad de Productos'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> unidades<br/>'
        },

        series: [{
            name: 'Ventas',
            colorByPoint: true,
            data: generarDatosGraficaBarrasVentas(data)
        }]

    });

}

/* Funciones para dibujar las graficas. Libreria : www.highcharts.com (un fuego!!) */
function dibujarGraficaBarrasPedidosComercios(data){
    // Create the chart
    $('#divGraficaPedidos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Cantidad de Pedidos de Comercios'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Cantidad de Pedidos'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> pedidos<br/>'
        },

        series: [{
            name: 'Comercio:',
            colorByPoint: true,
            data: generarDatosGraficaBarrasPedidos(data)
        }]

    });

}
